number = int(input(">>"))
bits = int(input(">>"))
bin_list = []

def binary_calc(number):
    count = bits
    string = ""
    while count > 0:
        if number//count==1:
            string = string+"1"
            number -= count
        else:
            string= string+"0"
        count = count//2
    bin_list.append(string)
    print(bin_list)


def anti_bin_calc(bin_list):
    for i in bin_list:
        count = 1
        total = 0
        for x in range(len(i)-1, -1, -1):
            if int(i[x]) == 1:
                total += count
            count = count*2
        print(total)

binary_calc(number)
anti_bin_calc(bin_list)
