d = {}

d['name'] = "stanley" # add items
del d['name'] # remove entry with key 'name'
d.clear()  # clears whole dictionary

for i in range(1,4): # runs from range 1 through 3
    li = []  # creates an emtpy list
    li.append(input("input name " + str(i) + ": ")) # appends a name to the list
    li.append(input("input age " + str(i) + ": "))  # appends an age to the list
    d[i] = li  # adds the current list to the dictionary
               # runs the code till loop ends
print(d) #prints final result

d = {}

for i in range(3):
    dict = {}
    dict["name"] = input("input name " + str(i+1) + ": ")
    dict["age"] = input("input age " + str(i+1) + ": ")
    d[i] = dict

print(d)
for i in range(len(d)):
    print(d[i]["name"], end=" ")
    print(d[i]["age"])