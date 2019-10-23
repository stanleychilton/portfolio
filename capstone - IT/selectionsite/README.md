# selectionsite

### Description

This repository contains all nessesary code for a website and the mysql data to go with it plus merges/recieves data contained in [this repo](https://github.com/stanleychilton/ITproject) the best way to run this website is on a test server which i found xampp was the best way to run this.

For students to access the website they must access the index.php file from the url and for the admins to access their seperate webpage they must access the login.php file in their url

**(installation guide below)**


---


### Required software

1. **Xampp**
2. **AWScli** (install guide below) 
3. **boto3** for python (install guide below)

---
### AWScli Setup
1. Create a new IAM user(This can be done in the userd tab in the My security credentials page)
2. Once the user is created press the security credentials tab to access keys
3. Press create access key 
4. Save these 2 keys somewhere on your computer
5. In the command Prompt enter 'aws configure'
6. For access key and security key enter the 2 keys that you have saved
7. For region enter the region your account is in
8. For output format enter json
9. You will now be able to access any aws cli commands 

### Setup

1. Install boto3 using the commands below in your command line.
   - `pip install boto3`
2. Install awscli.
    - for windows using [AWScli (64bit)](https://s3.amazonaws.com/aws-cli/AWSCLI64PY3.msi) / [AWScli (32bit)](https://s3.amazonaws.com/aws-cli/AWSCLI32PY3.msi)
    - for linux/mac the pip command `pip install awscli`
3. Install [xampp](https://www.apachefriends.org/index.html)
4. Navigate to the htdocs folder in the xampp file structure and paste all the website data.
5. Click mysql admin on the xampp control panel. create a database table called itproject. 
6. Import the mysql database from the file in the given folder.
7. Create a new user account on the database, (hostname = localhost) then add all this information to the connect.php file.
8. If portforwarding this you can run the python script from [this repo](https://github.com/stanleychilton/ITproject) on any computer just make sure to change the address how ever if not portforwarding for the test you will need to change the url in the python scripts in [this repo](https://github.com/stanleychilton/ITproject) to localhost and run them on the same machine
testing over a network can be tested using [this site](http://www.clicker-box.com/selectionsite/)
9. You should now be able to use the website

### Chatroom Setup

1. Click Admin on the xampp control panel to go to the database 
2. Create a new database called chatroom
3. Copy the sql queries from chat_database.sql and paste them into the sql section of the database
4. Copy the 2 queries seperately from chat_database1.sql and paste them one by one into the sql section of the database
5. Chatroom should be all setup now
