'''
Nasdaq Stock
Stock data extractory
To Use:
ticker = 'xxx'
stock_data = nasdaq_stock.stock(ticker)
'''
import requests
from lxml import html
from datetime import datetime
import mysql.connector
import socket
import time
import config
import gspread
from oauth2client.service_account import ServiceAccountCredentials
import sell_stocks as ss

mydb = mysql.connector.connect(
    host=config.host,
    user=config.user,
    password=config.password,
    database=config.database

)

hostname = socket.gethostname()
IPAddr = socket.gethostbyname(hostname)

mycursor = mydb.cursor()

seconds = time.time()

price_xp = '/html/body/div[1]/div/div/div[1]/div/div[2]/div/div/div[4]/div/div/div/div[3]/div[1]/div/span[1]/text()'

global run
run = True

scope = ['https://spreadsheets.google.com/feeds', 'https://www.googleapis.com/auth/drive']
creds = ServiceAccountCredentials.from_json_keyfile_name('current_secret.json', scope)
client = gspread.authorize(creds)

sheet = client.open('current_investments').sheet1


def stock(ticker, buy, current1, current2, current3):
    global run
    '''
    Retrieves stock ticker informantion.
    :param ticker: Valid nasdaq stock ticker.
    :return: Dictionary of stock information.
    '''
    ticker = ticker.upper()

    url = "https://finance.yahoo.com/quote/{ticker}?p={ticker}&.tsrc=fin-srch".format(ticker=ticker)

    headers = {
        'upgrade-insecure-requests': "1",
        'user-agent': "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
        'accept': "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
        'cache-control': "no-cache"
    }

    response = requests.request("GET", url, headers=headers)

    NAS = False
    if response.status_code == 200:
        data = html.fromstring(response.content)
        # print(type(data))#Debug
        try:
            check = data.xpath('//*[@id="quote-header-info"]/div[2]/div[1]/div[1]/h1/text()')
            if len(check) > 0:
                NAS = False
            else:
                return (False)
        except:
            return (False)

        try:
            Stock = ticker.upper()
            rd_bid_ask = data.xpath(price_xp)

            price = rd_bid_ask[0].strip()
            ask = rd_bid_ask[0].strip()

        except:
            return (False)

        now = datetime.now()
        dt_string = now.strftime("%H%M")
        if dt_string >= "0720":
            run = False

        ##########
        #
        # add sell check here
        stock_dic = {'price': str(price)}

        if (current3 < current2) and (current3 > buy):  # (float(buy)+(float(buy)*.07)) <= float(price):
            ss.sell_single(ticker, buy, price)
            run = False
        else:
            ########

            # print(stock_dic)
            sql = "UPDATE Purchased_stocks SET price3 = %s, price2 = %s, price1 = %s WHERE symbol = %s"
            stock_list = (str(price), current3, current2, str(ticker))
            mycursor.execute(sql, stock_list)
            # sheet.insert_row(stock_list)

            mydb.commit()

            # print(mycursor.rowcount, "record inserted.")
    else:
        stock_dic = {'ticker': 'Not-Available', \
                     'price': 'Not-Available', \
                     'ask': 'Not-Available', \
                     'range_val': str('Not-Available'), \
                     'vol': 'Not-Available', \
                     'vol_avg': str('Not-Available'), \
                     'previous_close': str('Not-Available'), \
                     'high': str('Not-Available'), \
                     'low': str('Not-Available')}
    return stock_dic


def print_stock(dic_stock):
    print('Price          :' + dic_stock.get('price'))
    print('Range          :' + dic_stock.get('range_val'))
    print('Volume         :' + dic_stock.get('vol'))
    print('Avg Volume     :' + dic_stock.get('vol_avg'))
    print('Previous Close :' + dic_stock.get('previous_close'))
    print('High           :' + dic_stock.get('high'))
    print('Low            :' + dic_stock.get('low'))


def main():
    global run
    while run:
        # print(run)
        newcursor = mydb.cursor()
        newcursor.execute("SELECT * FROM purchased_stocks")

        myresult = newcursor.fetchall()
        # print(myresult)
        start_time = time.time()
        for x in myresult:
            print(x)
            report = stock(x[1], x[2], x[3], x[4], x[5])
            # print(report.keys())
            # print_stock(report)
        print("running again, time taken for loop", str(time.time() - start_time))


if __name__ == '__main__':
    main()
