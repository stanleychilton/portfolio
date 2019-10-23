import os, os.path, shutil, time, datetime

def store(path):
    a = datetime.datetime.now()
    files = []
    skipped = 0
    if os.path.exists(path) and os.path.isdir(os.path.join(path, "file_storage")):
        print("dir exists")
        logger("info", "Directory exists", path)
    else:
        os.mkdir(os.path.join(path, "file_storage"))
        os.mkdir(os.path.join(path, "file_storage", "files"))
        f = open(os.path.join(path, "file_storage", "index.txt"), "w")
        f.close()
        print("dir was created")
        logger("info", "Directory created", path)

    f = open(os.path.join(path, "file_storage", "index.txt"), "r")
    files = f.readlines()
    f.close()

    for item in os.walk(path):
        for file in item[2]:
            if not os.path.exists(os.path.join(path, "file_storage", "files", file)):
                files.append(file + "\n")
                shutil.copy(os.path.join(item[0], file), os.path.join(path, "file_storage", "files", file))
                logger("info", file + "added to " + path + "\\files from " + item[0], path)
                os.remove(os.path.join(item[0], file))
            else:
                skipped += 1
                logger("warn", file + "was skipped ", path)

    f = open(os.path.join(path, "file_storage", "index.txt"), "w")
    for i in files:
        f.write(i)
    f.close()
    logger("info", str(skipped) + " files already exist, skipping these. given path was " + path, path)
    b = datetime.datetime.now()
    logger("info", "Time taken was " + str(b-a), path)

def logger(type, log_mes, path=None):
    if not(os.path.exists(os.path.join(path, "file_storage", "logger.txt"))):
        file = open(os.path.join(path, "file_storage", "logger.txt"), "w")
        file.close()
    f = open(os.path.join(path, "file_storage", "logger.txt"), "r")
    filecout = f.readlines()
    f.close()
    filecout.append('{} - {} - {}\n'.format(time.strftime("%H:%M:%S"), type.upper(), log_mes))
    f = open(os.path.join(path, "file_storage", "logger.txt"), "w")
    f.writelines(filecout)
    f.close()


store(input("master file path of require docs: "))






























