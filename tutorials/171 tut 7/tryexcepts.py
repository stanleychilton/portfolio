while True:
    try:
        user_in = int(input(">> "))
        print("answer: " + str(user_in+user_in))
        break
    except:
        print("input a number")
