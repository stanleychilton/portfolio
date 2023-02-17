import mysql.connector
import socket
#import time
import config
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

run = True

mycursor = mydb.cursor()

mycursor.execute("SELECT * FROM current_stocks WHERE price <= 1 ORDER BY price")

myresult = mycursor.fetchall()

mycursor.execute("SELECT * FROM purchased_stocks")

myresult1 = mycursor.fetchall()

stocks_to_purchase = []
names_list = []

while run:

    now = datetime.datetime.now()
    dt_string = now.strftime("%H%M")
    if dt_string >= "0720":
        run = False

    mycursor = mydb.cursor()

    mycursor.execute("SELECT count(*) FROM purchased_stocks")

    count = mycursor.fetchall()

    true_count = int(count[0][0])
    if true_count >= 10:
        print("False")
        run = False
    else:
        for y in myresult1:
            names_list.append(y[1])
        for i in myresult:
            allowed = False
            ### risk analysis starts here
            if i[1] in names_list:
                pass
            else:
                stock_val = us.stock(i[1])
                print(stock_val)
                stocks_to_purchase.append(stock_val)
                if len(stocks_to_purchase) == 10:
                    break

            ### risk analysis ends here
        for x in stocks_to_purchase:
            if true_count == 10:
                run = False
            else:
                sql = "INSERT INTO purchased_stocks (symbol, buy_price) VALUES (%s, %s)"
                values = (x[10], x[2])
                mycursor.execute(sql, values)
                myresult.pop(0)
                mydb.commit()
                true_count += 1

mydb.close()






# sql = "INSERT INTO current_stocks (symbol, date, time, price, ask, range_val, vol, vol_avg, Previous_close, high, low) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
#
# for x in myresult:
#     print(x[1:12])
#     stock_list = (x[1], x[2], x[3], x[4], x[5], x[6], x[7], x[8], x[9], x[10], x[11])
#     mycursor.execute(sql, stock_list)
#
#     mydb.commit()
