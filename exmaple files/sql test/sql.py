import mysql.connector
import socket
import time

mydb = mysql.connector.connect(
    host = '192.168.1.65',
    user = "clickerboxapp",
    password = "3GT52ed6SmhEhZm6",
    database = "clickerbox"

)

hostname = socket.gethostname()
IPAddr = socket.gethostbyname(hostname)


seconds = time.time()

mycursor = mydb.cursor()

sql = "INSERT INTO post (cat_id, Mod_name, Date, topic, ip) VALUES (%s, %s, %s, %s, %s)"
val = ("0" ,"swoged", seconds, "first mobile app test!", IPAddr)
#mycursor.execute(sql, val)

#mydb.commit()

print(mycursor.rowcount, "record inserted.")


mycursor = mydb.cursor()

mycursor.execute("SELECT * FROM post")

myresult = mycursor.fetchall()

for x in myresult:
  print(x)