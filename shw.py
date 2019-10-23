file = open("filetest.txt", "r")
files_test = []

test = file.readlines()

for i in test:
    files_test.append(i.strip("\n"))

print(files_test[1])