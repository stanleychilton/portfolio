#!/usr/bin/python3
# -*- coding: UTF-8 -*-
import sys
sys.path.append("H:\\apps\\Python27\\lib\\site-package")
import cgi
import psycopg2
from random import choice
import string
import smtplib
from email.mime.text import MIMEText
from email.header import Header
import ssl
# import globalvar as gl

def GenPassword(length=8, chars=string.digits):
    return ''.join([choice(chars) for i in range(length)])

vc = GenPassword(6)
vc = int(vc)
# gl._init()
print("Content-type: text/html\n")
print("<title>change_password</title>")
print("<body><center>")

try:
    # get post data
    print("")
    form = cgi.FieldStorage()  # 得到网页的暂存
    name = form['name'].value if 'name' in form else ''
    email = form['email'].value if 'email' in form else ''
    moodle_pwd = form['moodle_pwd'].value if 'moodle_pwd' in form else ''
    ftp_pwd = form['ftp_pwd'].value if 'ftp_pwd' in form else ''

    a = name+"\n"+email+"\n"+moodle_pwd+"\n"+ftp_pwd+"\n"
    modified = open('userinfo.txt', "w")
    modified.write(a)
    modified.close()

    # send an email
    if len(moodle_pwd) == 0 and len(ftp_pwd) == 0:
        print("Please enter the password you want to change")
    elif (len(moodle_pwd) <= 8 and len(ftp_pwd) == 0) or (len(moodle_pwd) == 0 and len(ftp_pwd) <= 6) or moodle_pwd.isdigit() or moodle_pwd.isalpha():
        print("Please enter a password that meets the requirements.")
    else:
        mail_host = "smtp.gmail.com"  # 设置服务器
        mail_user = "517wangyacong@gmail.com"
        mail_pass = "wangyacong517"

        receivers = ['%s'%email]  # 接收邮件，可设置为你的QQ邮箱或者其他邮箱
        message = MIMEText('the verification code is ' + '%d' %vc, 'plain', 'utf-8')
        message['From'] = Header("moodle site", 'utf-8')
        message['To'] = email

        subject = 'MOODLE --  changing password'
        message['Subject'] = Header(subject, 'utf-8')

        context = ssl.create_default_context()

        try:
            with smtplib.SMTP("smtp.gmail.com", 587) as server:
                server.ehlo()
                server.starttls(context=context)
                server.ehlo()
                server.login(mail_user, mail_pass)
                server.sendmail(mail_user, receivers, message.as_string())
            print("send succssful")
        except smtplib.SMTPException as e:
            print(e)
        print("""
        <form action="change.py" method="POST">
            verification code:<br><input type="text"  name="vc" id="vc" value="" required="required" size=20 ><br>
            <input type="submit" id="button" value="Submit verification code">
        </form>
        <script language = "JavaScript">
        var tvc = %d
        var btn = document.getElementById("button");
        var vc = document.getElementById("vc");
        btn.onclick =function(){
            if (tvc == vc.value )
            {   alert("right!");}
            else{
            alert("wrong ,input your things again");
            window.history.back(-1);
            }
        }
    </script>
        """ % (vc))
        print(
            "If you have not received the email after waiting for a long time, please return to the original interface and resend the verification code.")

except psycopg2.Error as e:
    print("Database Error: {}".format(e))

    # print("<br>Query: {}".format(query))
print("""
<form action="../PWD.html" method="GET">
    <input type="submit" value="GO BACK TO THE PAGE">
</form>
""")
print('</center></body>')
