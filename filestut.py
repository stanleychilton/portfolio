file = open("testfiile.txt", "w")
stringlist = ["test", "test2"]

for i in range(5):
   stringlist.append(input("add to line " + str(i+1) + ": "))

print(stringlist)
#
# for items in stringlist:
#     file.writelines(items + '\n')

file.writelines(stringlist)

file = open("testfiile.txt", "r")
test_list = []

test = file.readlines()

for i in test:
    test_list.append(i.strip("\n"))
print(test_list)