import datetime, keyboard

hour, minute = 0, 0
button_press = 0
old = 0

while True:
    tnow = datetime.datetime.now()
    if tnow.hour == hour and tnow.minute == minute:
        print("time reached")
        break
    else:
        pass
    if keyboard.is_pressed('a'):
        user_input = input("")
        if user_input.upper() == "H":
            hour += 1
            print(hour, minute)
        elif user_input.upper() == "M":
            minute += 1
            print(hour, minute)
