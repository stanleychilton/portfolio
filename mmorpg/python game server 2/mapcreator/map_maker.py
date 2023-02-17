from tree import tree
import pickle

map = [tree(20,20,50,50,(255,0,0))]

with open('../map_data/map.txt', 'wb') as filehandle:
    pickle.dump(map, filehandle)