import os, os.path, shutil, time, datetime


######################################################
################### store function ###################
######################################################
def store(path):
    a = datetime.datetime.now()
    files = []
    skipped = 0
    if os.path.exists(path) and os.path.isdir(os.path.join(path, "files_storage")):
        print("Archive Directory exists")
    else:
        os.mkdir(os.path.join(path, "files_storage"))
        os.mkdir(os.path.join(path, "files_storage", "files"))
        f = open(os.path.join(path, "files_storage", "index.txt"), "w")
        f.close()
        print("Archive Directory not yet created")
        
    f = open(os.path.join(path, "files_storage", "index.txt"), "r")
    files = f.readlines()
    f.close()

    for item in os.walk(path):
        for file in item[2]:
            if not os.path.exists(os.path.join(path, "files_storage", "files", file)):
                files.append(file + '\n')
                print(file + " ---- " + item[0] +  " ---- " + path)
                shutil.copy(os.path.join(item[0], file), os.path.join(path, "files_storage", "files", file))
                logger("info", file + " added to " + path + "\objects from " + item[0], path)
                os.remove(os.path.join(item[0], file))
            else:
                logger("warn", file + " was skipped", path)
                skipped += 1
    f = open(os.path.join(path, "files_storage", "index.txt"), "w")
    print(files)
    for i in files:
        f.write(i)
    f.close()
    logger("info", str(skipped) + " files already exist, skipping these. given path was " + path, path)
    b = datetime.datetime.now()
    logger("info", "Time taken was " + b-a, path)


######################################################
################### logger function ##################
######################################################
def logger(type, log_mes, path=None):
    if not(os.path.exists(os.path.join(path, "files_storage", "Logger.txt"))):
        file = open(os.path.join(path, "files_storage", "Logger.txt"), "w")
        file.close()
    f = open(os.path.join(path, "files_storage", "Logger.txt"), "r")
    filecont = f.readlines()
    f.close()
    filecont.append('{} - {} - {}\n'.format(time.strftime("%H:%M:%S"), type.upper(), log_mes))
    f = open(os.path.join(path, "files_storage", "Logger.txt"), "w")
    f.writelines(filecont)
    f.close()

store(input("master file path of required docs: "))

