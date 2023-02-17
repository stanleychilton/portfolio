import socket
from _thread import *
import pickle
from player import Player

trees = {"tree" : (1, 10, 1), "oak" : (10 , 20, 2)}
items = { 1: ("log"), 2 : ("oak log"), 3 : ("willow log")}
player = Player(50, 50, 50, 50, (255,0,0), [0,0,0,0,0,0,0],[1,1,1,1,1,1,1],[83,83,83,83,83,83,83], 50, 50, [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0])
players = {}  ## dictionary used to store the currently connected player

def server_program():
    currentPlayer = 0
    print("waiting for connection... server started")
    while True:
    # get the hostname
        host = socket.gethostname()
        port = 5001  # initiate port no above 1024

        server_socket = socket.socket()  # get instance
        # look closely. The bind() function takes tuple as argument
        server_socket.bind((host, port))  # bind host address and port together

        # configure how many client the server can listen simultaneously
        server_socket.listen(2)

        conn, address = server_socket.accept()  # accept new connection
        print("Connection from: " + str(address))
        start_new_thread(threaded_client, (conn, currentPlayer))
        currentPlayer += 1

def threaded_client(conn, player):
    players[player] = Player(50, 50, 50, 50, (255, 0, 0), [0, 0, 0, 0, 0, 0, 0], [1, 1, 1, 1, 1, 1, 1],
                    [83, 83, 83, 83, 83, 83, 83], 50, 50,  [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0])
    while True:
        # receive data stream. it won't accept data packet greater than 1024 bytes
        data1 = conn.recv(1024).decode()
        if not data1:
            # if data is not received break
            break
        if str(data1.split()[0]) == "woodcut":
            players[player].set_woodcutting_xp(trees[data1.split()[1]][1])
            players[player].output()

        conn.send(pickle.dumps(players[player]))  # send data to the client

    conn.close()  # close the connection


if __name__ == '__main__':
    server_program()