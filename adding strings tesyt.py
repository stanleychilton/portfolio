num1 = ["2", "1"]
num2 = ["0", "0", "1"] # 2468
answer = []
readding = []

# for i in range(9,3,-1):
#     num1.append(str(i))
#     num2.append(str(i))
#
# print(num1, num2)

i = 0
previous_remain = 0 #int
while i < len(num2):
    if previous_remain > 0:
        num1[i] = int(num1[i]) + previous_remain #int
        previous_remain = 0
    current_calc = int(num1[i]) + int(num2[i]) #int
    if current_calc >= 10:
        previous_remain = 1
        answer.append(str(current_calc-10))
    else:
        answer.append(str(current_calc))
    i += 1


while previous_remain > 0:
    if i < len(num1):
        current_calc = int(num1[i]) + 1
        print("current", current_calc)
        if current_calc >= 10:
            answer.append(str(current_calc-10))
        else:
            answer.append(str(current_calc))
            previous_remain = 0
    else:
        answer.append("1")
        previous_remain = 0
    i += 1

while len(answer) < len(num1):
    answer.append(num1[i])
    i += 1
# for i in range(0,len())
print("pre", previous_remain)
print(answer)
