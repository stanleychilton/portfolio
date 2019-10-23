import os, os.path, hashlib, pickle, shutil,time, sys


myArchive = "~\\Desktop\\myArchive"
myArchive = os.path.expanduser(myArchive)

######################################################
################### init function ####################
######################################################
def init():
    print(myArchive)
    if os.path.exists(myArchive) and os.path.isdir(myArchive):
        print("Archive Directory exists")
    else:
        os.mkdir(myArchive)
        os.mkdir(os.path.join(myArchive, "objects"))
        f= open(os.path.join(myArchive,"index.txt"),"w")
        f.close()
        print("Archive Directory being created")

######################################################
################### store function ###################
######################################################
def store(path):
    file = open(os.path.join(myArchive,"index.txt"),mode='rb')
    try:
        d = pickle.load(file)
    except EOFError as e:
        d = {}

    file.close()

    f= open(os.path.join(myArchive,"index.txt"),"wb")
    skip_count = 0

    for item in os.listdir(path):
        sig = createFileSignature(os.path.join(path, item))
        if not os.path.exists(os.path.join(myArchive,"objects", sig[1])):
            print(item)
            d[os.path.join(path, sig[0])] = sig[1]
            shutil.copy(os.path.join(path, item), os.path.join(myArchive, "objects", sig[1]))
            logger("info", "" + sig[0] + " with the hash " + sig[1] + " stored")
        else:
            skip_count += 1
    if skip_count > 0:
        print("files already added: ", skip_count)
    pickle.dump(d,f)
    logger("info", "" + str(skip_count)+" item duplicates skipped, otherwise successful")
    f.close()

######################################################
################### hashing function #################
######################################################
def createFileSignature (filename):

    f = None
    signature = None
    try:
        filesize  = os.path.getsize(filename)

        f = open(filename, "rb")  # open for reading in binary mode
        hash = hashlib.sha1()
        s = f.read(16384)
        while (s):
            hash.update(s)
            s = f.read(16384)

        hashValue = hash.hexdigest()
        signature = (filename, hashValue)
    except IOError:
        signature = None
    except OSError:
        signature = None
    finally:
        if f:
            f.close()
    return(signature)

######################################################
################### backup function ##################
######################################################
def backup_list(path = None):
    file = open(os.path.join(myArchive,"index.txt"),mode='rb')
    try:
        d = pickle.load(file)
        for key in d:
            if not path:
                    print(key)
            else:
                if path in key:
                    print(key)
    except EOFError as e:
        logger("error", "Empty file open attempted")

######################################################
################### test function ####################
######################################################
def filetests():
    file = open(os.path.join(myArchive, "index.txt"), mode='rb')
    count = 0
    err_index = []
    try:
        d = pickle.load(file)
        for key in d:
            if (os.path.exists(os.path.join(myArchive, "objects", d[key]))):
                count += 1
            else:
                err_index.append(key)

        logger("info", ""+str(count)+" items are stored correctly")

        checklist = os.listdir(os.path.join(myArchive, "objects"))
        for item in os.listdir(os.path.join(myArchive, "objects")):
            for key in d:
                if item == d[key]:
                    checklist.remove(item)
        if len(checklist) >= 1:
            for i in checklist:
                logger("error", ""+ i +" has no corrersponding file details")

        for i in err_index:
            logger("error", "" + i + " has no corrersponding file")

    except EOFError as e:
        logger("error", "Empty file open attempted")


######################################################
################### get function #####################
######################################################
def get(def_path):
    dic = {}
    count = 1
    file = open(os.path.join(myArchive, "index.txt"), mode='rb')
    try:
        d = pickle.load(file)
        for i in d:
            if def_path.lower() in i.lower():
                dic[count] = i
                count += 1
        if len(dic) > 1:
            print(dic)
            for i in dic:
                print(i, dic[i])
            user = int(input("which would you like to restore: "))
            shutil.copy(os.path.join(myArchive, "objects", d[dic[user]]), dic[user])
    except EOFError as e:
        logger("error", "Empty file open attempted")

######################################################
################### restore function #################
######################################################
def restore():
    file = open(os.path.join(myArchive, "index.txt"), mode='rb')
    try:
        d = pickle.load(file)
        for i in d:
            shutil.copy(os.path.join(myArchive, "objects", d[i]), i)
    except EOFError as e:
        logger("error", "Empty file open attempted")

######################################################
################### logger function ##################
######################################################
def logger(type, log_mes):
    if not(os.path.exists(os.path.join(myArchive, "Logger.txt"))):
        file = open(os.path.join(myArchive, "Logger.txt"), "w")
        file.close()
    f = open(os.path.join(myArchive, "Logger.txt"), "r")
    filecont = f.readlines()
    f.close()
    filecont.append('{} - {} - {}\n'.format(time.strftime("%H:%M:%S"), type.upper(), log_mes))
    f = open(os.path.join(myArchive, "Logger.txt"), "w")
    f.writelines(filecont)
    f.close()

######################################################
################### main function ####################
######################################################
def main():
    list = ["init", "filetest", "restore", "store <filename>",
            "backuplist <filename/pattern>", "get <filename/pattern>"]

    item = None
    function = None
    if (len(sys.argv) < 2):
        print("\nno function name detected, valid functions:")
        for i in list:
            print(">" + i)
    else:
        function = sys.argv[1]
    if function == "init":
        init()
    elif function == "filetest":
        filetests()
    elif function == "restore":
        restore()
    else:
        if (len(sys.argv) == 3):
            item = sys.argv[2]
        if function == "store":
            if len(sys.argv) < 3:
                print("\nstore usage \"store <filename>\"")
            else:
                store(item)
        elif function == "backuplist":
            if len(sys.argv) < 3:
                print("\nbackup list usage \"store <filename/pattern>\"")
            else:
                backup_list(item)
        elif function == "get":
            if len(sys.argv) < 3:
                print("\nget usage \"store <filename/pattern>\"")
            else:
                get(item)


if (__name__ == "__main__"):
    main()

# init()
# store("E:\hardtech holidays")
#backup_list()
# file = open(os.path.join(myArchive, "index.txt"), mode='rb')
# d = pickle.load(file)
# file.close()
# del d["D:\project management\Chapter 3 Slides_Project Selection.ppt"]
# f = open(os.path.join(myArchive, "index.txt"), mode='wb')
# pickle.dump(d,f)
# f.close()
# filetests()
#get("external")
#restore()
#logger("test")
