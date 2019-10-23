import math
menu_list = ["A - Chop Tree", "B - Chop Oak", "C - Chop Willow"] # standard tree 25xp, oak 37.5xp, willow 67.5
xp_rate = [25000, 37.5, 67.5]
starting_xp = 83
current_level = 1
current_xp = 0
next_level = starting_xp


def chop_tree(index):
    global current_xp
    current_xp += xp_rate[index]
    check_level()

def check_level():
    global current_level, next_level
    max_xp = int(next_level)
    if current_xp >= max_xp:
        if current_level == 1:
            current_level += 1
            next_level = int(max_xp + (max_xp * (1+(10/100))))

        else:
            current_level += 1
            next_level = max_xp + (math.floor(current_level + 300 * (2 ** (current_level/ 7.0)))/4)

    menu()

def menu():
    menu_ = True
    while menu_:
        print("pick an action")
        print()
        print("**** leveling System ****")
        print(current_level)
        print(current_xp)
        print(next_level)
        for i in menu_list:
            print("\t", i)

        command = input("command: ")
        if command.upper() == "A":
            chop_tree(0)
        elif command.upper() == "B":
            chop_tree(1)
        elif command.upper() == "C":
            chop_tree(2)
        else:
            print("Invalid entry")

menu()