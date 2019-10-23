# This is a very basic HTTP server which listens on port 8080,
# and serves the same response messages regardless of the browser's request. It runs on python v3
# Usage: execute this program, open your browser (preferably chrome) and type http://servername:8080
# e.g. if server.py and broswer are running on the same machine, then use http://localhost:8080

# Import the required libraries
from socket import *
import random

# Listening port for the server
serverPort = 8000

# Create the server socket object
serverSocket = socket(AF_INET, SOCK_STREAM)

# Bind the server socket to the port
serverSocket.bind(('', serverPort))

# Start listening for new connections
serverSocket.listen(1)

print('The server is ready to receive messages')

moves = ['1','2','3','4','5','6','7','8','9']

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
            string = string + chr(request[count])
        count += 1
    #print(request)
    if "GET" in str(request):
        #print(string)
        try:
            f = open(string[2:], "rb")
            files = f.readlines()

            stringline = bytearray()
            for i in files:
                stringline = stringline + i

        except FileNotFoundError:
            f = open("error.html", "rb")
            files = f.readlines()

            stringline = bytearray()
            for i in files:
                stringline = stringline + i
        stringline = ((stringline.decode())[0:116]+ "__"+moves[0]+ "__|__"+moves[1]+ "__|__"+moves[2]+ "__<br>__"+moves[3]+ "__|__"+moves[4]+ "__|__"+moves[5]+ "__<br>__"+moves[6]+ "__|__"+moves[7]+ "__|__"+moves[8]+ "__"+ (stringline.decode())[116:]).encode()
        # create HTTP response
        response = ("HTTP /1.1 200 OK\n\n".encode()) + stringline

        # send HTTP response back to the client
        connectionSocket.send(response)

        # Close the connection
        connectionSocket.close()
    elif "POST" in str(request):
        numpick = True
        print(str(chr(request[-1])))
        try:
            var = int(chr(request[-1]))
        except:
            var = str(chr(request[-1]))
        if var == "t":
            moves = ['1', '2', '3', '4', '5', '6', '7', '8', '9']
        elif str(var) in moves:
            if moves[var-1] == "x" or moves[var-1] == "o":
                print("nothing")
            else:
                moves[var - 1] = "x"

            for i in range(0,9,3):
                if moves[i] + moves[i+1] + moves[i+2] == "xxx":
                    print("player wins")
                elif moves[i] + moves[i+1] + moves[i+2] == "ooo":
                    print("computer wins")

            for i in range(0,3,1):
                if moves[i] + moves[i+3] + moves[i+6] == "xxx":
                    print("player wins")
                elif moves[i] + moves[i+3] + moves[i+6] == "ooo":
                    print("computer wins")

            horizontal = moves[0] + moves[4] + moves[8]
            if horizontal == "xxx":
                print("player wins")
            elif horizontal == "ooo":
                print("computer wins")

            horizontal2 = moves[2] + moves[4] + moves[6]
            if horizontal2 == "xxx":
                print("player wins")
            elif horizontal2 == "ooo":
                print("computer wins")

            while numpick:
                num = random.randint(1, 9)
                if moves[num - 1] == "x" or moves[num - 1] == "o":
                    pass
                else:
                    numpick = False
                    moves[num-1] = "o"

        else:
            pass

        try:
            f = open("game.html", "rb")
            files = f.readlines()

            stringline = bytearray()
            for i in files:
                stringline = stringline + i

        except FileNotFoundError:
            f = open("error.html", "rb")
            files = f.readlines()

            stringline = bytearray()
            for i in files:
                stringline = stringline + i
        stringline = (
        (stringline.decode())[0:116] + "__" + moves[0] + "__|__" + moves[1] + "__|__" + moves[2] + "__<br>__" +
        moves[3] + "__|__" + moves[4] + "__|__" + moves[5] + "__<br>__" + moves[6] + "__|__" + moves[7] + "__|__" +
        moves[8] + "__" + (stringline.decode())[116:]).encode()

        # create HTTP response
        response = ("HTTP /1.1 200 OK\n\n".encode()) + stringline

        # send HTTP response back to the client
        connectionSocket.send(response)
        # send HTTP response back to the client

        # Close the connection
        connectionSocket.close()

