import os
print(os.listdir())
def copyfile(ex_file, new_file):
    try:
        ex_f = open(ex_file, "r")
        olditems = ex_f.readlines()

        new_f = open(new_file, "w")
        for i in olditems:
            new_f.write(i)
    except:
        print(2+2)
        print("hi there was a problem")
        print("Couldnt find file: " + str(ex_file))
    return

copyfile(1, "newfile.txt")