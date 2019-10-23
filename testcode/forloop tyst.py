string = ""

for i in range(1,4):
    for x in range(1*i-1,3*i):
        string += str(x)
    string += "\n"

print(string)