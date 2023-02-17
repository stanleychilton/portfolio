import socket
import pickle
import config

bit_size = 2048 * 8


class network:
    def __init__(self):
        self.client = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

        self.server = config.ip
        self.port = config.port

        self.addr = (self.server, self.port)
        self.p = self.connect()

    ## used to get the players connection
    def getp(self):
        return self.p

    ## connecting to the server to pull the data and unpack it (pickle.loads)
    def connect(self):
        try:
            self.client.connect(self.addr)
            return pickle.loads(self.client.recv(bit_size))
        except:
            pass

    ##packages the data to be sent (pickle.dumps) and loads the recieved data
    def send(self, data):
        try:
            self.client.send(pickle.dumps(data))
            return pickle.loads(self.client.recv(bit_size))
        except socket.error as e:
            print(e)
