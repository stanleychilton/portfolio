# return a value

# def maths(num1, num2):
#     total = num1 + num2
#     return total
#
#
# print(maths(1, 3))
#
#
# returnedval = maths(5,10)
# print(returnedval)



#print this value

# def maths2(num1, num2):
#     total = num1-num2
#     print(total)
#     print(num1-num2)
#
# maths2(4,5)

# def calc(amount1, amount2):
#     total1 = amount1 * .15
#     total2 = amount2 * .20
#     return total1, total2
#
# num1, num2 = calc(100,400)
# print(num1)
# print(num2)


def tax_calc(amount, rate):
    gst = amount * (rate/100)
    return gst


def main():
    user_in = int(input(">> "))
    for i in range(5,11,5):
            tax = tax_calc(user_in, i)
            print("tax:", tax)

main()

# f = open("text.txt", "w")