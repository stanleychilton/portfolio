import random, os

running = True
games_history = []

if 'results.txt' in os.listdir('.'):
    f = open('results.txt', 'r')
    loaded = f.readlines()
    f.close()

    for items in loaded:
        newlist = items.strip('\n')
        games_history.append(newlist)

def initilize():
    max_num = int(input("what would you like the max number to be? "))
    number = random.randint(0,max_num)
    return number

def gameloop(num):
    global running
    guesses = 0
    guess = []

    print("input a number guess:")
    while running == True:
        user_guess = int(input(">>"))
        guesses += 1
        guess.append(user_guess)
        if user_guess > num:
            print("too high")
        elif user_guess < num:
            print("too low")
        elif user_guess == num:
            print("you win!")
            games_history.append((str(num) , "number of guesses: " + str(guesses), "guesses: " + str(guess)))
            replay = input("play again? (y/n)")
            if replay.lower() == "y":
                gameloop(initilize())
            elif replay.lower() == "n":
                print("goodbye!")
                running = False
    return

gameloop(initilize())
f = open('results.txt', 'w')
for i in games_history:
    f.write(str(i) + '\n')
f.close()
























