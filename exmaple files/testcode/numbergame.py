import random, os

running = True
games_history = []

if 'results.txt' in os.listdir('.'):
    f = open('results.txt', "r")
    loaded = f.readlines()
    f.close()

for items in loaded:
    newlist = items.strip('\n')
    games_history.append(newlist)

def initilize():
    max_num = int(input("Maximum range of numbers: "))
    number = random.randint(0,max_num)
    return number

def mainloop(num):
    global running
    guesses = 0

    guess = []
    print("Try to guess the number!")
    while running == True:
        user_in = int(input(">>"))
        guesses += 1
        guess.append(user_in)
        if user_in > num:
            print("Too high")
        elif user_in < num:
            print("Too low")
        elif user_in == num:
            print("Correct")
            games_history.append(("number of guesses: " + str(guesses), "guesses: " + str([guess])))
            replay = input("would you like to play again?(y/n) ")
            if replay.lower() == "n":
                print("goodbye!")
                running = False
            elif replay.lower() == "y":
                mainloop(initilize())
    return 0

mainloop(initilize())
f = open("results.txt", "w")
for i in games_history:
    f.write(str(i) + '\n')
f.close()
