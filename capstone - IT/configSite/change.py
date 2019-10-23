#!/usr/bin/python3
# -*- coding: UTF-8 -*-
import sys
sys.path.append("H:\\apps\\Python27\\lib\\site-package")
import cgi
import psycopg2
import hashlib
import pymysql
import os

print("Content-type: text/html\n")
print("<title>change_password</title>")
print("<body><center>")
os.system("sudo chmod o+r userinfo.txt")
os.system("sudo chmod o+w userinfo.txt")
l=[]
conf = open('userinfo.txt',"r")
for i in conf:
#     print(i)
    test = i.split('\n')  # 这里变成了 list ['I','love','python']
    test = ''.join(test)
#     print(len(test))
    l.append(test)
conf.close()
# print(l)
name = l[0]
email = l[1]
moodle_pwd =l[2]
ftp_pwd=l[3]


# change password
if len(moodle_pwd)>=1 :
    m = hashlib.md5()
    m.update(moodle_pwd.encode(encoding='utf-8'))
    result = m.hexdigest()
    try:
        os.system("sudo chmod o+r /etc/mysql/debian.cnf")
        username = ""
        pwd = ""
        with open("/etc/mysql/debian.cnf", "r") as f:
            for line in f.readlines():
                if (line.find('user') == 0):
                    username = line[11:-1]
                if (line.find('password') == 0):
                    pwd = line[11:-1]
        f.close()

        con = pymysql.connect(host="127.0.0.1", user=username, password=pwd, port=3306)
        # 创建游标 ， 利用游标来执行sql语句
        cur = con.cursor()
        query ="use moodle"
        cur.execute(query)
        query1 ="update mdl_user set password ='%s' where mdl_user.email ='%s';"%(name, result)
        cur.execute(query1)
        cur.execute("flush privileges;")
        cur.close()
        con.close()
        print("Changed moodle password successful, log in to try")
        # create the config.php in moodle
    except  psycopg2.Error as e:
        print("Database Error: {}".format(e))

if len(ftp_pwd)>=1:
    os.system("sudo echo ftpuser:%s| sudo chpasswd"%(ftp_pwd))
    print("Changed ftp password successful, log in to try")
if len(moodle_pwd)<1 and len(ftp_pwd)<1:
    print("something wrong !")

print("""
<form action="../PWD.html" method="GET">
    <input type="submit" value="GO BACK TO THE PAGE">
</form>
""")
print('</center></body>')
