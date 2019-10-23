user_in = int(input())

first = 4
close=2018

launch = 26
while True:
    if first == 13:
        close += 1
        first = 1
    if launch == 26:
        launch = 0
        if close == user_in:
            print("yes")
            break
        elif close > user_in:
            print("no")
            break

    first += 1
    launch += 1
