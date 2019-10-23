#!/usr/bin/python3
import os

os.system("sudo mkdir /var/www/html/cgi-bin")
os.system("sudo chmod -R 777 /var/www/html")
os.system("sudo mv /home/ubuntu/configSite/PWD.html /var/www/html")
os.system("sudo mv /home/ubuntu/configSite/Forget_PWD.py /var/www/html/cgi-bin/Forget_PWD.py")
os.system("sudo mv /home/ubuntu/configSite/change.py /var/www/html/cgi-bin/change.py")

os.system("sudo apt-get -y install python3-psycopg2")

os.system("sudo chmod +x /var/www/html/cgi-bin/Forget_PWD.py")
os.system("sudo chmod +x /var/www/html/cgi-bin/change.py")

os.system("sudo chmod o+r /etc/apache2/sites-enabled/000-default.conf")
os.system("sudo chmod o+w /etc/apache2/sites-enabled/000-default.conf")
os.system("sudo chmod o+r /home/ubuntu/configSite/cgiconf.txt")
os.system("sudo chmod o+w /home/ubuntu/configSite/cgiconf.txt")
newsta=""
# os.system("sudo chmod a+w /etc/apache2/sites-enabled/000-default.conf")
cgiconf = open('/home/ubuntu/configSite/cgiconf.txt',"r")
newsta = cgiconf.read()
cgiconf.close()

with open("/etc/apache2/sites-enabled/000-default.conf", 'r+') as f3:
    f3.seek(0)
    f3.truncate()
    f3.writelines(newsta)
f3.close()

os.system("sudo ln -s /etc/apache2/mods-available/cgid.load /etc/apache2/mods-enabled/")
os.system("sudo ln -s /etc/apache2/mods-available/cgid.conf /etc/apache2/mods-enabled/")
os.system("sudo service apache2 restart")
os.system("sudo bash /home/ubuntu/configSite/wdpwd.sh")
