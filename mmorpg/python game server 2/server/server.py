import socket
from _thread import *
from player import Player
from UI import *
import pickle
import random
import config
import mysql.connector
import os

# creates the player data folder inside the games directory if it doesnt exist
if not os.path.exists("player_data"):
    print("player_data directory doesnt exist... Creating")
    os.mkdir("player_data")

mydb = mysql.connector.connect(
    host=config.host,
    user=config.user,
    password=config.password,
    database=config.database

)

bit_size = 2048 * 8

print(config.ip)
server = config.ip
port = config.port

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

try:
    s.bind((server, port))  ## trys to bind sever to this ip and port will print error if unsuccessful
except socket.error as e:
    print(e)

s.listen(0)  ## will listen on this port until a connection is attempted

print("waiting for connection... server started")

players = {}  ## dictionary used to store the currently connected player
map = []
ui = [QuitButton()]

## not currently limited to anything can limit to 1000 or something at some point

def threaded_client(conn, player):
    conn.send(pickle.dumps("conn"))
    ## this loop here will be used to connect to the login side of the script, currently just assigns the player values and
    while True:
        data_l = pickle.loads(conn.recv(bit_size))  ## recieving the data (login information)
        print(data_l)
        mycursor = mydb.cursor()
        mycursor.execute("SELECT * FROM player WHERE name = '"+ data_l[0] + "' and password = '" + data_l[1] + "'")
        myresult = mycursor.fetchall()
        print(data_l)
        if len(myresult) == 1:  # checks for a current registered account
            #  assigns a player their starting content if they are logging in for the first time
            if len(myresult[0][4]) == 0:
                # creates a filepath to write their original player_data too
                filepath = "player_data/"+myresult[0][1]+".data"

                # creates file
                f = open(filepath, "wb")
                f.close()
                # adds filepath to players database
                mycursor = mydb.cursor()
                sql = "UPDATE player SET game_data = %s WHERE name = %s"
                values = (filepath, myresult[0][1])
                mycursor.execute(sql, values)

                mydb.commit()

                # initial player data
                players[player] = Player(0, 0, 50, 50,(random.randint(0, 255), random.randint(0, 255), random.randint(0, 255)), 10, 10)
            else:
                # assigns the players data file path to a var from database connection
                filepath = myresult[0][4]

                #reads the data from the players save file
                with open(filepath, 'rb') as filehandle:
                    player_data = pickle.load(filehandle)

                # assigns player data to their player object when they connect and data is loaded
                players[player] = Player(player_data[0],player_data[1],player_data[2],player_data[3],player_data[4],player_data[5],player_data[6])
            conn.send(pickle.dumps((200, players[player], ui)))  # sending the initial player data to the player, pickle is used to package it (sort of like a zip)
            break
        else:
            conn.send(pickle.dumps((4043, 404)))
        try:
            pass
        except:
            conn.send(pickle.dumps((4044, 404)))

    reply = ""
    while True:
        try:
            data = pickle.loads(conn.recv(bit_size))  # recieves any data from the client
            print(data)
            if data[0] == 1:
                players[player] = data[1]  # updating player pos on the server end

            if not data:  # checks for any new data and if there is none detects the disconnect
                print("disconnected")
                break
            else:

                with open('../map_data/map.txt', 'rb') as filehandle:
                    map = pickle.load(filehandle)

                # maybe need a new function??
                ## this is what is sent back to this client containing all the other players data (will be changed to only nearby players at some stage to reduce network use)
                reply = players  # players[:player] + players[player+1:]

            #### change this for more players?
            # if player == 1:
            #     reply = players[0]
            # else:
            #     reply = players[1]

            # print("recieved", data)
            # print("sending ", reply)
            if data[0] == 1:
                conn.sendall(pickle.dumps(reply))  ## packages(pickle) the reply to send to the client and then sends it
            if data[0] == 2:
                conn.sendall(pickle.dumps(map)) ## sending map data from maps folder
            #if data[0] == 3: ## this will be for when a player is cutting a tree

        except:
            break

    print("Lost connection")
    ## closes the connection with the client this is where saving the player data to the database will happen
    ## as there will still be current data for this player before its removed from the connected players dict
    conn.close()

    # hashes and saves the players data to a .data file in the player data directory
    with open(filepath, 'wb') as filehandle:
        pickle.dump(players[player].save_data(), filehandle)

    ## removes the player from the current connected players dictionary
    players.pop(player)


def without_keys(d, keys):  ## this function is to remove the sending and recieving of the players data to themself as
    # they already have their gamestate. not currently working, can see a sort of jumpy movement on your client due to this currently
    return {x: d[x] for x in d if x not in keys}


currentPlayer = 0  ## assigns the current connecting player the current value of current player so we can see the current users onlineand also id them in the players dictionary
while True:  ## infinite loop looking/waiting for connections
    conn, addr = s.accept()  ##player has joined connection accepted notes connection data and the address connected from
    print("connected to:", addr)

    # print(players) ## this line is to display the list (on the server end) for testing purposes when players join and disconnect
    start_new_thread(threaded_client,
                     (conn, currentPlayer))  ## starts a thread on the server connecting to the specfic client
    currentPlayer += 1  ## incriments the current player to assign a new unique id to the next connecting player
