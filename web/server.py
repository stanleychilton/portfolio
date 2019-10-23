#This is a very basic HTTP server which listens on port 8080, 
#and serves the same response messages regardless of the browser's request. It runs on python v3
#Usage: execute this program, open your browser (preferably chrome) and type http://servername:8080
#e.g. if server.py and broswer are running on the same machine, then use http://localhost:8080

# Import the required libraries
from socket import *

# Listening port for the server
serverPort = 80

# Create the server socket object
serverSocket = socket(AF_INET,SOCK_STREAM)

# Bind the server socket to the port
serverSocket.bind(('',serverPort))

# Start listening for new connections
serverSocket.listen(1)

print('The server is ready to receive messages')


while True:
    # Accept a connection from a client
	connectionSocket, addr = serverSocket.accept()

    ## Retrieve the message sent by the client
	request = connectionSocket.recv(1024)

	string = ""
	firspc = 0
	count = 0

	while True:
		if chr(request[count]) == " " and firspc == 1:
			break
		if chr(request[count]) == " ":
			firspc = 1
		if firspc == 1:
			string = string+chr(request[count])
		count += 1


	try:
		f = open(string[2:], "rb")
		print(string[2:])
		files = f.readlines()

		stringline = bytearray()
		for i in files:
			stringline = stringline+i
	except FileNotFoundError:
		f = open("error.html", "rb")
		files = f.readlines()
		stringline = bytearray()
		for i in files:
			stringline = stringline+i

	print(stringline)


    #create HTTP response
	response = ("HTTP /1.1 200 OK\n\n".encode()) + stringline

	#send HTTP response back to the client
	connectionSocket.send(response)


    # Close the connection
	connectionSocket.close()

