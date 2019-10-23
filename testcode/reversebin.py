user_in = int(input(""))
num = 0
user_in = str(bin(user_in))
cur = 1
for i in range(2, len(user_in)):
    if user_in[i] == '1':
        num += cur
    cur *= 2

print(num)
