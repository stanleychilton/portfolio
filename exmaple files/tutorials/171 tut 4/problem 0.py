# number = 5
#
# if number == 3:
#     print("hello")
# elif number == 5:
#     print("some other condition")
# else:
#     print("number wasnt matching")

# x = 10
#
# while True:
#     print(x)
#     x = x - 1
#     if x == 0:
#         break

x = 1
total = 0

while x <= 10:
    cubed = x**3
    print(str(x)+"\t"+str(cubed))
    total += cubed
    x += 1

print("Total:", total)

# x = 1
# total = 0
#
# while x <= 10:
#     if x != 3:
#         cubed = x**3
#         print(str(x)+"\t"+str(cubed))
#         total += cubed
#     x += 1
#
# print("Total:", total)

# while True:
#     try:
#         user_in = str(input(">> "))
#         if user_in == "":
#             break
#     except:
#         print("wrong type")

# a = 5
# b = 11
# c = 14
# d = 21

# if not a + b > d - c or a + b < c - d:
#  print("True")
# else:
#  print("False")

# if a + b > d - c or a + b < c - d:
#  print("True")
# else:
#  print("False")

# if a + b > d - c:
#  print("True")
# else:
#  print("False")

# if a + b > d - c and a + b < c - d:
#  print("True")
# else:
#  print("False")
