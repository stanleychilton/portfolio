import os, random, time

menu_list = ["O - Open account", "L - Load details", "D - Display details", "A - Make deposit", "W - Make withdraw", "S - Save", "Q - Quit"]

creation_list = ["Account owners full name: ", "Email: ", "Address: ", "Phone number: "]
account_types = ["Savings", "tertiary", "Streamline"]
account_info = ["Original balance: $"]

current_information = ["N/A", "N/A", "N/A"]

loaded_account = ""

account_path = ""

def save():
    pass

def open_account():                              ### complete
    numberpicking = True                         ### creates a folder
    user_details = []                            ### creates details file
    if current_information[0] != "N/A":          ### randomly generates a user id that isnt in use yet,
        save()
    while numberpicking:
        num = random.randint(1,10)#random.randint(111111111111,999999999999)
        print("test")
        print(num)
        if not os.path.exists(os.path.join("accounts", str(num))):
            numberpicking = False
            os.mkdir(os.path.join("accounts", str(num)))
    details = open(os.path.join("accounts", str(num), "details.txt"), "w")

    for i in creation_list:
        value = input("\t" + i)
        if value.upper() == "C":
            menu()
        else:
            user_details.append(value)
    user_details.append("date created: " + time.strftime("%d/%m/%Y"))
    user_details.append("time created: " + time.strftime("%H:%M:%S"))



    number_accounts = int(input("How many sub-accounts would you like to open? "))

    for i in range(number_accounts):
        not_created = True
        count = 0
        counter = 1
        for i in account_types:
            count += 1
            print("\t" + str(count) + ". " + i)
        while not_created:
            while True:
                try:
                    acc_type = int(input("which account type would you like? "))
                    break
                except:
                    print("please enter a number")
            if not os.path.exists(os.path.join("accounts", str(num), account_types[acc_type-1]+".txt")):
                not_created = False
                account = open(os.path.join("accounts", str(num), account_types[acc_type-1]+".txt"), "w")
                if counter <= 1:
                    user_details.append(account_types[acc_type-1])
                counter += 1
                file_information = []
                for x in account_info:
                    value = input("\t" + x)
                    if value.upper() == "C":
                        menu()
                    else:
                        file_information.append(value)
                file_information.append(time.strftime("%d/%m/%Y") + " - Account opened - $" + file_information[0])
                for i in file_information:
                    account.write(str(i) + "\n")
            else:
                print("this account already exists")


    for i in user_details:
        details.write(str(i) + "\n")






def menu():
    for i in menu_list:
        print(i)
    user_inp = input("which option would you like? ")
    if user_inp.upper() == "O":
        open_account()
    elif user_inp.upper() == "L":
        pass
    elif user_inp.upper() == "D":
        pass
    elif user_inp.upper() == "A":
        pass
    elif user_inp.upper() == "W":
        pass
    elif user_inp.upper() == "S":
        pass
    elif user_inp.upper() == "Q":
        pass
    else:
        print("please choose another option" + '\n')
        menu()



menu()