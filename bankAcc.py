menu_list = ["O - Open account", "L - load details", "D - Display details",
             "A - Make deposit", "W - Make withdraw", "S - Save", "Q- Quit"]

creation_list = ["Account owner's full name: ", "Starting balance: $"]

current_information = ["N/A", "N/A", "N/A"]
save_path = 'bank_accounts/'
information_file = 'information/'

current_newbank_number = open(information_file + "bankid.txt", "r")
idnumber = int(current_newbank_number.readline() or '0')

current_newbank_number.close()

current_files = open(information_file + "files.txt", "r")
filenames = current_files.readlines()
filenames = [line.strip() for line in filenames]
current_files.close()

def save():
    global current_information
    save_name = open_(save_path + str(current_information[0]) + ".txt", "w")
    for i in current_information:
        save_name.write(str(i) + "\n")

def open_():
    global idnumber, current_information
    file_information = []
    if current_information[0] != "N/A":
        save()
    file_information.append(idnumber)
    idnumber += 1
    print("Type C at any point to abort creation")
    for i in creation_list:
        value = input("\t" + i)
    if value.upper() == "C":
        menu()
    else:
        file_information.append(value)
    file_information.append("Account opened - $ " + file_information[1])
    current_information = file_information

    save_name = open(save_path + str(file_information[0]) + ".txt", "w")
    for i in file_information:
        save_name.write(str(i) + "\n")

    current_files_ = open(information_file + "files.txt", "w")
    filenames.append(file_information[0])
    for i in filenames:
        current_files_.write(str(i) + "\n")

    id_file = open(information_file + "bankid.txt", "w")
    id_file.write(str(idnumber))

def deposit():
    amount = int(input("how much would you like to deposit"))
    current_information[2] = int(current_information[2]) + amount
    current_information.append("Deposit - $" + str(amount))
def withdraw():
    amount = int(input("How much would you like to withdraw? "))
    current_information[2] = int(current_information[2]) - amount
    current_information.append("Withdraw - $" + str(amount))

def quit_():
    if current_information[0] != "N/A":
        save()
    quit()

def menu():
    menu_ = True
    while menu_:
        print("Load or Create an account")
        print()
        print("**** Banking System ****")
        for i in menu_list:
            print("\t", i)

        command = input("command: ")
        if command.upper() == "O":
            open_()
        elif command.upper() == "L":
            load()
        elif command.upper() == "D":
            display()
        elif command.upper() == "A":
            deposit()
        elif command.upper() == "W":
            withdraw()
        elif command.upper() == "S":
            save()
        elif command.upper() == "Q":
            quit_()
        else:
            print("Invalid entry")

menu()