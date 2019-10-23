name = 0

while name != "goodbye":
    name = input("what is your name: ")
    if name.lower() == "goodbye":
        print("goodbye")
    else:
        print("hello my name is " + name)