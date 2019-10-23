
# items = []

user_in = input("Save to what file: ")
# f = open(user_in, "w")
with open(user_in, "w") as f:
    while True:
            user_item = input()
            if user_item != ".":
                f.write(user_item + "\n")
            else:
                break

f.close()

