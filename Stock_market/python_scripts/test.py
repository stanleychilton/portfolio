from datetime import datetime

buy = 1
price = 1.2

print((buy+(buy*.1)))

if (buy+(buy*.1)) <= price:
    print("true")
else:
    print("false")

# datetime object containing current date and time



now = datetime.now()

print(now)

# dd/mm/YY H:M:S

dt_string = now.strftime("%H%M")
b = '2030'
time1 = datetime.strptime(dt_string,"%H%M")
time2 = datetime.strptime(b,"%H%M")
diff = time2 - time1
diff.total_seconds()




#print(dt_string)
#print(dt_string == "03:19")
