import mysql.connector
import socket
import time
import config

mydb = mysql.connector.connect(
    host=config.host,
    user=config.user,
    password=config.password,
    database=config.database

)

hostname = socket.gethostname()
IPAddr = socket.gethostbyname(hostname)


seconds = time.time()

mycursor = mydb.cursor()

sql1 = "TRUNCATE TABLE current_stocks"
mycursor.execute(sql1)
mydb.commit()

mycursor.execute("SELECT * FROM all_stocks WHERE price <= 2")

myresult = mycursor.fetchall()

sql = "INSERT INTO current_stocks (symbol, date, time, price, ask, range_val, vol, vol_avg, Previous_close, high, low) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"

for x in myresult:
    print(x[1:12])
    stock_list = (x[1], x[2], x[3], x[4], x[5], x[6], x[7], x[8], x[9], x[10], x[11])
    mycursor.execute(sql, stock_list)

    mydb.commit()
