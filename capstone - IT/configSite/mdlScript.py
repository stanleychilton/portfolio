#!/usr/bin/python
import os

#download moodle

os.chdir("/opt")
os.system("sudo git clone https://github.com/moodle/moodle.git")
os.chdir("/opt/moodle")
os.system("sudo git branch -a")
os.system("sudo git branch --track MOODLE_36_STABLE origin/MOODLE_36_STABLE")
os.system("sudo git checkout MOODLE_36_STABLE")
os.system("sudo cp -R /opt/moodle /var/www/html/")
os.system("sudo mkdir /var/moodledata")
os.system("sudo chown -R www-data /var/moodledata")
os.system("sudo chmod -R 777 /var/moodledata")
os.system("sudo chmod -R 0755 /var/www/html/moodle")

#write things in mysqld.cnf
os.system("sudo chmod o+w /etc/mysql/mysql.conf.d/mysqld.cnf")
x=0
newsta=""
with open("/etc/mysql/mysql.conf.d/mysqld.cnf","r+") as f:
    for line in f.readlines():
        if(line.find('default_storage_engine = innodb') == 0):
            x=1
#             print("s")
    f.seek(0)
    print(len(newsta))
    for line in f.readlines():
        if(line.find('skip-external-locking') == 0)and x==0:
            line="skip-external-locking"+"\ndefault_storage_engine = innodb\ninnodb_file_per_table = 1\ninnodb_file_format = Barracuda\n"
        newsta=newsta+line

f.close()
with open("/etc/mysql/mysql.conf.d/mysqld.cnf", 'r+') as f:
    f.writelines(newsta)
f.close()
os.system("sudo chmod o-w /etc/mysql/mysql.conf.d/mysqld.cnf")
os.system("sudo service mysql restart")

#os.system("sudo apt -y install python3-pip")
#os.system("python3 -m pip install pymysql")
#find user and password

os.system("sudo chmod o+r /etc/mysql/debian.cnf")
username=""
pwd=""
with open("/etc/mysql/debian.cnf","r") as f:
    for line in f.readlines():
        if(line.find('user') == 0):
            username=line[11:-1]
        if(line.find('password') == 0):
            pwd=line[11:-1]
f.close()

import pymysql
print("find the top level user and password",username,pwd)
# 连接mysql数据库
con = pymysql.connect(host="127.0.0.1",user=username,password=pwd,port=3306)
# 创建游标 ， 利用游标来执行sql语句
cur = con.cursor()
sql1="CREATE DATABASE moodle DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 
sql2="create user 'moodledude'@'%' IDENTIFIED BY 'PWD123pwd@';"

cur.execute(sql1)
cur.execute(sql2)

cur.execute("GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,CREATE TEMPORARY TABLES,DROP,INDEX,ALTER ON moodle.* TO moodledude@localhost IDENTIFIED BY 'PWD123pwd@';")

cur.close()
con.close()
#create the config.php in moodle
os.chdir("/var/www/html/moodle")
os.system("sudo touch config.php")

#setup the config.php
import socket,struct,fcntl
p = os.popen("curl ifconfig.me")
publicIP = p.read()
f = open('/var/www/html/moodle/config.php','w')
f.write("<?php // Moodle configuration file \n"
"\n"
"unset($CFG);\n"
"global $CFG;\n"
"$CFG = new stdClass();\n"
"\n"
"$CFG->dbtype = 'mysqli';\n"
"$CFG->dblibrary = 'native';\n"
"$CFG->dbhost = 'localhost';\n"
"$CFG->dbname = 'moodle';\n"
"$CFG->dbuser = 'moodledude';\n"
"$CFG->dbpass = 'PWD123pwd@';\n"
"$CFG->prefix = 'mdl_';\n"
"$CFG->dboptions = array (\n"
" 'dbpersist' => 0,\n"
" 'dbport' => '',\n"
" 'dbsocket' => ''\n,"
" 'dbcollation' => 'utf8mb4_unicode_ci',\n"
" );\n"
" \n"
"$CFG->wwwroot = 'http://%s/moodle';\n"
"$CFG->dataroot = '/var/moodledata';\n"
"$CFG->admin = 'admin';\n"
"\n"
"$CFG->directorypermissions = 0777;\n"
"\n"
"require_once(__DIR__ . '/lib/setup.php');\n"
"\n"
"// There is no php closing tag in this file,\n"
"// it is intentional because it prevents trailing whitespace problems!\n"%(publicIP))
f.close()
os.system("sudo php /var/www/html/moodle/install.php")
os.system("sudo sh /home/ubuntu/configSite/phpmyadmin.sh")
#os.system("sudo chmod -R 777 /var/www/html/moodle")
#os.system("sudo chmod -R 0755 /var/www/html/moodle")

os.chdir("/home/ubuntu")
os.system("sudo python3 /home/ubuntu/configSite/cgiScript.py")
os.system("sudo python3 /home/ubuntu/configSite/ftp-script.py")
os.system("sudo python3 /home/ubuntu/configSite/autoW.py")
os.system("git clone https://github.com/fish258/awsAlarm.git")
os.system("sudo python3 /home/ubuntu/awsAlarm/alarm.py")
