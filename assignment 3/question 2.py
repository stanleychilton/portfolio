def load():
    f=open('testtxt.txt','r')
    string = f.readlines()
    fileList = []
    for i in range(len(string)):
        fileList = fileList + string[i].split()
    return fileList

def frequencies_using_lists(lyrics):
    myList = []
    print("earlier")
    for i in range(len(lyrics)):
        lock_out = 0
        for x in range(len(myList)):
            if myList[x][0] == lyrics[i]:
                myList[x][1] += 1
                lock_out = 1
        if lock_out == 0:
            myList.append([lyrics[i], 1])
    return myList

def frequencies_using_dictionaries(lyrics):
    myDict = {}
    for i in lyrics:
        if i in myDict:
            myDict[i] += 1
        else:
           myDict[i] = 1
    return myDict


test_list = load()
print(frequencies_using_lists(test_list))
print(frequencies_using_dictionaries(test_list))
