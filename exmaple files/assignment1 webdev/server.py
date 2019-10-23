from socket import *
import _thread
import xml.etree.ElementTree as et
import time
import json
import requests
# import urllib.request
# import shutil


serverSocket = socket(AF_INET, SOCK_STREAM)

serverPort = 8080

serverSocket.bind(("", serverPort))

serverSocket.listen(5)
print('The server is running')


# Server should be up and running and listening to the incoming connections


def process(connectionSocket):
    try:
        # Receives the request message from the client
        message = connectionSocket.recv(1024)
        # Extract the path of the requested object from the message
        print(message)
        filename = message.decode(encoding='UTF-8').split()[1]

        #print ('File name is: ' + filename[1:])
        filename = filename[1:]
        # Because the extracted path of the HTTP request includes
        # a character '/', we read the path from the second character

#############################################################################
        if(filename == "statusupdate"):
            check = ""
            for i in range(len(str(message))):
                check = check + str(message)[i]
                if("newstatus" in check):
                    index = i+10
                    break
            cur_str = str(message)[index:]
            check = ""
            for i in range(len(cur_str)):
                check = check + cur_str[i]
                if('----' in check):
                    indextwo = i - 7
                    break
            cur_str = cur_str[:indextwo]
            print(cur_str)


            tree = et.parse("status.xml")
            root = tree.getroot()

            try:
                last_element = root[-1].attrib
                new_element = int(last_element["id"]) + 1

                new_status = et.SubElement(root, "post", attrib={"id": str(new_element)})
            except:
                new_status = et.SubElement(root, "post", attrib={"id": "1"})
            new_message = et.SubElement(new_status, "message")
            new_date = et.SubElement(new_status, "date")
            new_time = et.SubElement(new_status, "time")
            likes = et.SubElement(new_status, "likes")

            new_message.text = cur_str
            likes.text = "0"
            new_date.text = time.strftime("%d/%m/%Y")
            new_time.text = time.strftime("%H:%M:%S")

            tree.write("status.xml")

            f = open("update.html")
            outputdata = f.read()

##########################################################################
        elif(filename=="addfriend"):

            check = ""
            for i in range(len(str(message))):
                check = check + str(message)[i]
                if ("name" in check):
                    index = i + 16
                    break
            cur_str = str(message)[index:]
            check = ""
            for i in range(len(cur_str)):
                check = check + cur_str[i]
                if ('----' in check):
                    indextwo = i - 7
                    break
            name = cur_str[:indextwo]
            #print(name)

            check = ""
            for i in range(len(str(message))):
                check = check + str(message)[i]
                if ("ipaddress" in check):
                    index = i + 10
                    break
            cur_str = str(message)[index:]
            check = ""
            for i in range(len(cur_str)):
                check = check + cur_str[i]
                if ('----' in check):
                    indextwo = i - 7
                    break
            ip = cur_str[:indextwo]
            #print(ip)


            file = open("friends.json", "r")
            text = file.readline()

            data = json.loads(text)


            new_data = {}
            new_data["name"] = name
            new_data["properties"] = {}
            new_data["properties"]["ip"] = ip

            data["friends"].append(new_data)

            print(data)

            with open("friends.json", "w") as f:
                json.dump(data, f)

            f = open("update.html")
            outputdata = f.read()
###########################################################################

        elif(filename=="update.py"):


            f = open("update.html")
            outputdata = f.read()


###########################################################################


        elif(filename=="friends.html"):
            f = open("friends.html")
            outputdata = f.read()
            #print(outputdata)
            with open('friends.json', 'r') as f:
                friends_dict = json.load(f)

            #print(friends_dict)
            txt = ""
            for distro in friends_dict["friends"]:
                friend_name = distro["name"]
                cur_ip = distro["properties"]["ip"]
                #print(cur_ip)
                try:
                    messages = []
                    like = []
                    r = requests.get('http://' + cur_ip + ':8080/status.xml')
                    # print("made it")
                    # url = 'http://' + cur_ip + ':8080/pic.jpeg'
                    #
                    # save_path = '/testimage.jpeg'
                    # print("test"+urllib.request.urlopen(url))
                    # with urllib.request.urlopen(url) as response, open(save_path, 'wb') as out_file:     ## couldnt work out how to send images across a network
                    #     shutil.copyfileobj(response, out_file)

                    file = open("temp.xml", "w").write(r.text)
                    tree = et.parse('temp.xml')
                    root = tree.getroot()
                    #print(root)
                    for child in root:
                        for i in child.iter('message'):
                            messages.append(i.text)
                        for i in child.iter('likes'):
                            like.append(i.text)
                    #print(file)
                    print(messages[-1])
                    txt = txt +"<p style='margin: 10 0 0 0px;'>name: " + friend_name + "<br>post: " + messages[-1] + "<br>likes: " + like[-1]
                    txt = txt + "<form id='likeForm'><input id='newfriend' name='name' value='" + friend_name + "' type='hidden'><input type='submit' value='Like Post'></form></p><br><br>"

                except:
                    print("Server offline")
            outputdata = outputdata + txt + "</body></html>"


####################################################################################
        elif (filename == "server.py"):
            f = open("update.html")
            outputdata = f.read()
        elif(filename=="pic.jpeg"):
            try:
                f = open("pic.jpeg", 'rb')
                files = f.readlines()
                stringline = bytearray()
                for i in files:
                    stringline = stringline+i
                outputdata = stringline
            except:
                print("no file")
                outputdata = "nothing"
##################################################################################
        elif(filename == "likepost"):
            f = open("friends.html")
            outputdata = f.read()

            check = ""
            for i in range(len(str(message))):
                check = check + str(message)[i]
                if ("name" in check):
                    index = i + 16
                    break
            cur_str = str(message)[index:]
            check = ""
            for i in range(len(cur_str)):
                check = check + cur_str[i]
                if ('----' in check):
                    indextwo = i - 7
                    break
            name = cur_str[:indextwo]
            #print(name)

            with open('friends.json', 'r') as f:
                friends_dict = json.load(f)

            #print(friends_dict)
            txt = ""
            for distro in friends_dict["friends"]:
                if distro["name"] == name:
                    cur_ip = distro["properties"]["ip"]

            print(cur_ip)
            r = requests.post("http://" + cur_ip + ":8080/appendlike", data={'name': 'stanley'})

##################################################################################
        elif(filename == "appendlike"):
            tree = et.parse('status.xml')
            root = tree.getroot()
            root[-1].find("likes").text = str(int(root[-1].find("likes").text) + 1) ## ran out of time to make the likes system save data in regards to whos liked their post
            tree.write('status.xml')

##################################################################################
        else:
            f = open(filename)
            outputdata = f.read()
        # Store the entire content of the requested file in a temporary buffer
        # Send the HTTP response header line to the connection socket
        response = "HTTP/1.1 200 OK\r\n\r\n"

        # Send the content of the requested file to the connection socket
        try:
            for i in range(0, len(outputdata)):
                response += outputdata[i]
            response += "\r\n"

            # Close the client connection socket
            connectionSocket.send(response.encode())
            connectionSocket.close()
        except:
            print("must've been a post lol")

    except (IOError, IndexError):  # Send HTTP response message for file not found
        response = "HTTP/1.1 404 Not Found\r\n\r\n"
        response += "<html><head></head><body><h1>404 Not Found</h1></body></html>\r\n"
        connectionSocket.send(response.encode())
        connectionSocket.close()

while True:
    # Set up a new connection from the client
    connectionSocket, addr = serverSocket.accept()
    # Clients timeout after 60 seconds of inactivity and must reconnect.
    connectionSocket.settimeout(60)
    # start new thread to handle incoming request
    _thread.start_new_thread(process, (connectionSocket,))

serverSocket.close()
