d = {}

for i in range(0,2):
    dict = {}
    dict["name"] = input("input a name " + str(i+1) + ": ")
    dict["age"] = input("input a age " + str(i+1) + ": ")
    d[i] = dict

print(d)

for i in range(len(d)):
    print(d[i]["name"], end=" ")
    print(d[i]["age"])