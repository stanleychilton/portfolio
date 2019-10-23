import random

# user_in = int(input("Enter limit: "))
#
# for i in range(1, user_in+1):
#     if i % 2 == 0:
#         print("Even")
#     else:
#         print("Odd")

# def print_alternates(lim, word1, word2):
#     for i in range(1, lim+1):
#         if i % 2 == 0:
#             print(word1)
#         else:
#             print(word2)
#
# print_alternates(10, "something", "test")

# storage = [0, 0, 0, 0]
#         ## sum, positive, negative, zeros
# sum = 0
# positives = 0
# negatives = 0
# zeros = 0
#
# for i in range(7):
#     user_in = int(input("Enter a number: "))
#     if user_in > 0:
#         positives += 1
#
#         storage[1] += 1
#     elif user_in < 0:
#         negatives += 1
#
#         storage[2] += 1
#     else:
#         zeros += 1
#
#         storage[3] += 1
#     sum += user_in
#
#     storage[0] += user_in
#
# print("sum: ", sum)
# print("positives: ",str(positives) + ", Negatives: ", str(negatives) + ", zeros: ", zeros)
#
# print("sum: ", storage[0])
# print("positives: ",str(storage[1]) + ", Negatives: ", str(storage[2]) + ", zeros: ", storage[3])

# head = 0
# tails = 0
#
# def coin_toss():
#     choice = random.randint(0,1)
#     if choice == 1:
#         return "Heads"
#     else:
#         return "tails"
#
#
# user_in = int(input("input something: "))
# for i in range(user_in):
#     current = coin_toss()
#     if current.upper() == "HEADS":
#         head += 1
#     else:
#         tails += 1
#     print(current)
#
# print(head, "x heads;", tails, "x tails")


def com_selection():
    com_choice = random.randint(0,2)
    if com_choice == 0:
        return "rock"
    elif com_choice == 1:
        return "paper"
    else:
        return "scissors"

while True:
    userscore = 0
    compscore = 0
    curmax = 0

    while curmax < 3:
        user_in = input("select a move (r,p,s)")
        com_in = com_selection()
        if user_in == "r" and com_in == "scissors":
            print("user wins")
            userscore += 1
        elif user_in == "p" and com_in == "rock":
            print("user wins")
            userscore += 1
        elif user_in == "s" and com_in == "paper":
            print("user wins")
            userscore += 1

        elif user_in == "r" and com_in == "paper":
            print("computer wins")
            compscore += 1
        elif user_in == "s" and com_in == "rock":
            print("computer wins")
            compscore += 1
        elif user_in == "p" and com_in == "scissors":
            print("computer wins")
            compscore += 1

        else:
            print("draw")

        print("user: ", str(userscore) + "; comp score: ", compscore)
        curmax = max(userscore, compscore)

    replay = input("replay? (Y/N)")
    if replay.upper() == "N":
        break
    elif replay.upper() == "Y":
        pass
    else:
        print("not valid")