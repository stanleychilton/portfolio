number = 10
bits = 8
bin_list = []

def binary_calc(number):
    count = bits
    string = ""
    while count > 0:
        if number//count == 1:
            string = string+"1"
            number -= count
        else:
            string = string+"0"
        count = count//2
    bin_list.append(string)
    print(bin_list)

binary_calc(number)