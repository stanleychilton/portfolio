# for i in range(0,3):
#     print(i, "this is the main loop")
#     for x in range(0,3):
#         print(str(i) + ",", x, "this is the second loop")

# nuts = ["peanut", "walnut", "almond", "pecan"]
# products = ["butter", "cake", "praline", "pie"]
#
# for type in nuts:
#     for product in products:
#         print(type, product)

user_in= (int(input("give size: ")))*2

for y in range(0,user_in, 2):
    max = user_in
    if not y % 2:
        min = y+1
    else:
        min = 2+y
    step = 2
    print()
    for i in range(2):
        for x in range(min, max, step):
            print(x, end=" ")
        for z in range(y):
            print(end="  ")
        min = (user_in)-1
        max = 0+y
        step = -2


for y in range(user_in,-1, -2):
    max = user_in
    if not y % 2:
        min = y+1
    else:
        min = 2+y
    step = 2
    for i in range(2):
        for x in range(min, max, step):
            print(x, end=" ")
        for z in range(y):
            print(end="  ")
        min = (user_in)-1
        max = 0+y
        step = -2
    print()