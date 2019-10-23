
list1 = ["the", "cat", "sat", "on", "mat"]


while True:
    user_in = input(">> ")
    user_in = user_in.split()
    user_in = ["cat", "on", "someones", "mat"]
    for i in user_in:
        if not i in list1:
            list1.append(i)

    print(list1)