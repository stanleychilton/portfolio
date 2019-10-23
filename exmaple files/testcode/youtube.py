import math
menu_list = ["A - chop tree","B - chop oak","C - chop willow"]
xp_rate = [25, 37.5, 67.5]
start_xp = 83
current_level = 1
current_xp = 0

def chop_tree(index):
    global current_xp
    current_xp += xp_rate[index]
    check_level()

def check_level():
    global current_level, start_xp
    max_xp = int(start_xp)
    if current_xp >= max_xp:
        current_level += 1
        if current_level == 1:
            start_xp = int(max_xp + (max_xp *(1+(10/100))))
        else:
            start_xp = max_xp + (math.floor(current_level + 300 * (2 ** (current_level/7)))/4)
    menu()



def menu():
    menu_ = True
    while menu_:
        print("pick an action")
        print()
        print("*** leveling system ***")
        print(current_level)
        print(current_xp)
        print(start_xp)
        for i in menu_list:
            print(i)
        command = input("command: ")
        if command.upper() == "A":
            chop_tree(0)
        elif command.upper() == "B":
            if current_level >= 15:
                chop_tree(1)
            else:
                print("you do not have the required level")
        elif command.upper() == "C":
            if current_level >= 30:
                chop_tree(2)
            else:
                print("you do not have the required level")
        else:
            print("not an option")

menu()












