number = 30
count = 32

bin_list = []

while count > 0:
    if number//count == 1:
        bin_list.append(1)
        number -= count
    else:
        bin_list.append(0)
    count = count//2

print(bin_list)