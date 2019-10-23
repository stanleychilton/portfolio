# for i in range(3):
#     for x in range(3):
#         print(str(i) + ",\t" + str(x))

# nuts = ["Peanut", "Walnut", "Almond", "Pecan"]
# products = ["Butter", "Cake", "Praline", "Pie"]

# for i in range(len(nuts)):
#     for x in range(len(products)):
#         print(nuts[i], products[x])

# for i in nuts:
#     for x in products:
#         print(i, x)

# count = 1
# num = 10
# while num <= 54:
#     for x in range(count):
#         print(num, end=" ")
#         num += 1
#         if num == 55:
#             break
#     count += 1
#     print()


user_in = int(input(">> "))


print(("o"*user_in)*2)
for x in range(user_in-2):
    for i in range(user_in*2+1):
        if i == 0 or i == user_in*2-1:
            print("o", end='')
        else:
            print(" ", end='')
    print()
print(("o"*user_in)*2)