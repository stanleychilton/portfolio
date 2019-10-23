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


## opening account
def open_account():
    numberpicking = True
    user_details = []
    if current_information[0] == "N/A":
        save()
    while numberpicking:
        num = random.randint(1,10)
        print("test")
        print(num)                                       ## creates the accounts details file
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
    user_details.append("Date created: " + time.strftime("%d/%m/%Y"))
    user_details.append("Time created: " + time.strftime("%H:%M:%S"))


    num_acc = int(input("How many accounts would you like? "))
    ##get rid
    for i in range(num_acc):    ## starts making accounts internal accounts
        not_created = True
        count = 0
        for i in account_types:
            count += 1
            print("\t" + str(count) + ". " + i)
        while not_created:
            while True:
                try:
                    acc_type = int(input("Which account would you like? "))
                    break
                except:
                    print("Please enter a number")
            if not os.path.exists(os.path.join("accounts", str(num), account_types[acc_type-1]+".txt")):
                not_created = False
                account = open(os.path.join("accounts", str(num), account_types[acc_type-1]+".txt"), "w")
                    ##get rid
                user_details.append(account_types[acc_type-1])
                    ## get rid
                file_info = []
                for x in account_info:
                    value = input("\t" + x)
                    if value.upper() == "C":
                        menu()
                    else:
                        file_info.append(value)
                file_info.append("Date created: " + time.strftime("%d/%m/%Y"))
                file_info.append("Time created: " + time.strftime("%H:%M:%S"))
                file_info.append(time.strftime("%d/%m/%Y") + " - Account opened - $" + file_info[0])
                for x in file_info:
                    account.write(str(x) + "\n")
            else:
                print("account already exists")

    for i in user_details:
        details.write(str(i)+ "\n")


def load():
    acc = input("what is the accounts number? ")
    
    pass


def menu():
    while True:
        for i in menu_list:
            print(i)
        user_inp = input("Which option would you like? ")
        if user_inp.upper() == "O":
            open_account()
        elif user_inp.upper() == "L":
            load()
        elif user_inp.upper() == "D":
            pass
        elif user_inp.upper() == "A":
            pass
        elif user_inp.upper() == "W":
            pass
        elif user_inp.upper() == "S":
            pass
        elif user_inp.upper() == "Q":
            quit()
        else:
            print("please choose another option")

menu()






















