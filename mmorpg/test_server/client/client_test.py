import socket
import pickle
from player import Player

def client_program():
    host = socket.gethostname()  # as both code is running on same pc
    port = 5001  # socket server port number

    client_socket = socket.socket()  # instantiate
    client_socket.connect((host, port))  # connect to the server

    message = input(" -> ")  # take input

    while message.lower().strip() != 'close':
        client_socket.send(message.encode())  # send message
        Player = pickle.loads(client_socket.recv(1024)) # receive response

        Player.output_as_text() # show in terminal

        message = input(" -> ")  # again take input

    client_socket.close()  # close the connection


if __name__ == '__main__':
    client_program()