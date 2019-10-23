
options = ["A - addition", "B - subtraction", "Q - quit"]

def addition(num1, num2):
    return num1 + num2


def subtraction(num1, num2):
    return num1 - num2

def get_inputs():
    number1 = int(input("input first number: "))
    number2 = int(input("input second number: "))
    return number1, number2



while True:
    #######
    for i in options:
        print(i)
    print()
    #######
    user_in = input("Choose your option: ")
    #######
    if user_in.upper() == "A":
        num1, num2 = get_inputs()
        print(addition(num1, num2))
    #######
    elif user_in.upper() == "B":
        num1, num2 = get_inputs()
        print(subtraction(num1, num2))
    #######
    elif user_in.upper() == "Q":
        break
    #######
    else:
        print("that is not an option\n")