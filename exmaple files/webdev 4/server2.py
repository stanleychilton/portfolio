# This is version 2 of the minimalistic (no frills)  HTTP server, which can now serve dynamic content.
# It listens on port 8080, and passes the client request (location name) to Google maps API. 
# The resulting XML data about location data is then relayed back to the client
# Usage: execute this program, open your browser (preferably chrome) and type http://servername:8080/location
# e.g. if server.py and broswer are running on the same machine, then use http://localhost:8080/auckland

# Import the required libraries
import pycurl
from socket import *
from io import BytesIO

# Listening port for the server
serverPort = 8080

# Create the server socket object
serverSocket = socket(AF_INET, SOCK_STREAM)

# Bind the server socket to the port
serverSocket.bind(('', serverPort))

# Start listening for new connections
serverSocket.listen(1)

print('The server is ready to receive messages')

while 1:
    # Accept a connection from a client
    connectionSocket, addr = serverSocket.accept()

    ## Retrieve the message sent by the client
    request = connectionSocket.recv(1024).decode('UTF-8')

    # Extract the requested resource from the path
    resource = request.split()[1].split("/")[1]

    # This is buffer to hold response from google map API server
    response_buffer = BytesIO()

    curl = pycurl.Curl()

    # Set the curl options which indentify the Google API server, the parameters to be passed to the API,
    # and buffer to hold the response
    curl.setopt(curl.URL,
                'https://maps.googleapis.com/maps/api/geocode/xml?key=AIzaSyAU0y5AGm-PdLrNhQAnARHFGj1fTuSLQ3s&address="' + resource + '"')
    curl.setopt(curl.WRITEFUNCTION, response_buffer.write)

    curl.perform()
    curl.close()

    response_value = response_buffer.getvalue().decode('UTF-8')

    # create HTTP response
    response = "HTTP /1.1 200 OK\n\n" + response_value

    # send HTTP response back to the client
    connectionSocket.send(response.encode())

    # Close the connection
    connectionSocket.close()

