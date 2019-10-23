# configSite
Please pay attention to No.7.
1. This is a automatic script group for setting up all a moodle sites for students needs. 

2. After running these scripts, students have their own moodle sites by typing own %IP_address/moodle on browser.(All basic configurations already have been set up. All the students need to do is configure their personal main administrator account which will have complete control over the site.)

3. After cloning this directory from this site, Run "python3 configSite/installLAMP.py" （Generally, the whole process will be finished within 3 min.）

4. The script files are automatic calling each other once users call the first script - installLAMP.py

(PS: Internal Running Order: installLAMP.py → installMYsql.sh → mdlScript.py → phpmyadmin.sh → ftp-script.py)


5. To access phpmyadmin to manage their database of moodle site:
Username: moodledude
Password: PWD123pwd@
When they access phpmyadmin, they can change their password to be private.

6. To access ftp system to manage their moodle site files:
① They should go to the website https://www.net2ftp.com first
② Use ip_address as FTP server
③ Use ftpuser as Username
④ Use 1234 as the Password 

7*(Attention please).
In mdlScript.py, we clone files from https://github.com/fish258/awsAlarm.git, which create alarms for the aws instance.
The command line will ask the manager for 4 things: AWS access key id, AWS Secret Access Key, Default region name, Default output format.(Because the aws need to be configured first so that the command line can connect the aws cloudwatch to set the alarm. But We can't post the private information on github.) The good news is that the manager just need to enter once. This is a one-time setup if your preferences don't change because the AWS CLI remembers your settings between sessions.

Information needs to be entered.
① AWS access key id and AWS Secret Access Key can be get from AWS account. 
② Default region name: should be the region where the server is located.(e.g. us-east-1 If your availability zone of instance is us-east-1b, eliminate the "b" at the end and put the default region name be us-east-1)
③ Default output format: text (If you didn't fill with text, the code may not work properly.) 

#Introduction of these files:

#1. installLAMP.py will install all software the moodle site needs. And it will call installMysql.sh, which could install mysql in silence.

#2. In addition, at the end of installLAMP.py, it calls mdlScript.py, which downloads moodle from github and set up some configuration.

#3. At the end of mdlScript.py(After creating mysql user of moodle), it calls phpmyadmin.sh to install phpmyadmin in silence. And at the same time, it uses moodle mysql user's name as username and pwd as pwd. 

#4. At the end of mdlScript.py(After running phpmyadmin.sh),it called configSite.py to create cgi connection ,and create cgi-bin folder ,to make Web access possible.

#5.Wdpwd.sh make the user "www-data" using coommand lines without password.
