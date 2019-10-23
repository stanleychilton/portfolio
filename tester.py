f = open("contiuous.txt", "w+")

for i in range(10):
    print(i)
    f.writelines(str(i) + "\n")

f.close