# def getNumber(prompt, whichtype):
#     while True:
#         user_in = input(prompt)
#         if whichtype.lower() == "float":
#             try:
#                 float(user_in)
#                 break
#             except:
#                 print("not a valid type")
#         elif whichtype.lower() == "integer":
#             try:
#                 int(user_in)
#                 break
#             except:
#                 print("not a valid type")
#
#
# getNumber("whats your height?", "integer")

# def toInt(num):
#     try:
#         return int(num)
#     except:
#         return num
#
# print(toInt('800') * 3)
# print ( toInt('cat') *3)

def toword(num):
    ones = ["one", "two", "three", "four", "five", "six", "seven", "eight", "nine", ""]
    tens = ["", "twenty","thirty","forty","fifty","sixty", "seventy", "eighty", "ninety"]

    if int(num) >= 20 and int(num) <=99:
        num1 = int(str(num)[0:1])
        num2 = int(str(num)[1:2])
        string = tens[num1-1] + " " + ones[num2-1]
    elif int(num) == 100:
        string = "one hundred"
    elif int(num) <= 9 and int(num) >= 1:
        string = ones[int(num)-1]

    return string

print(toword('9'))

while True:
    current = []
    user_in = input()
    if user_in == "":
        break

    user_in = user_in.split()

    for i in range(len(user_in)):
        try:
            int(user_in[i])
            current.append(toword(user_in[i]))
        except:
            current.append(user_in[i])

    print(" ".join(current))
