import mysql.connector
import socket
import config
import gspread
from oauth2client.service_account import ServiceAccountCredentials
import updating_stocks as us
import datetime

mydb = mysql.connector.connect(
    host=config.host,
    user=config.user,
    password=config.password,
    database=config.database

)

hostname = socket.gethostname()
IPAddr = socket.gethostbyname(hostname)

mycursor = mydb.cursor()

scope = ['https://spreadsheets.google.com/feeds', 'https://www.googleapis.com/auth/drive']
creds = ServiceAccountCredentials.from_json_keyfile_name('current_secret.json', scope)
client = gspread.authorize(creds)

sheet = client.open('current_investments').sheet1


def sell_single(ticker, buy, price):
    today = datetime.date.today().strftime('%B %d %Y')
    time = datetime.datetime.now().strftime('%H:%M:%S')
    vol = 100 / float(buy)
    diff = (float(price) - float(buy))
    profitloss = diff * vol
    row = [ticker, buy, price, diff, vol, profitloss, today, time]
    sheet.insert_row(row)
    sql = "DELETE FROM Purchased_stocks WHERE symbol = '" + str(ticker) + "'"
    mycursor.execute(sql)
    mydb.commit()
    us.stock(ticker)



def sell_all():
    newcursor = mydb.cursor()
    newcursor.execute("SELECT * FROM purchased_stocks")
    myresult = newcursor.fetchall()
    for x in myresult:
        if x[2] <= x[3]:
            today = datetime.date.today().strftime('%B %d %Y')
            time = datetime.datetime.now().strftime('%H:%M:%S')
            vol = 100 / float(x[2])
            diff = (float(x[3]) - float(x[2]))
            profitloss = diff * vol
            row = [x[1], x[2], x[3], diff, vol, profitloss, today, time]
            sheet.insert_row(row)
            sql = "DELETE FROM Purchased_stocks WHERE symbol = '" + str(x[1]) + "'"
            mycursor.execute(sql)
            mydb.commit()
            us.stock(x[1])
    row = ["End of day", "End of day", "End of day", "End of day", "End of day", "End of day", "End of day", "End of day"]
    sheet.insert_row(row)
