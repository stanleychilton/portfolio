in1 = list(input())
in2 = list(input())

string1 = ""
string2 = ""

length =  min(len(in1), len(in2))

in1.reverse()
in2.reverse()
i = 0

while True:
    if i == min(len(in1), len(in2)):
        if len(in1) > len(in2):
            for x in range(len(in2), len(in1)):
                string1 = in1[x] + string1
        elif len(in1) < len(in2):
            for x in range(len(in1), len(in2)):
                string2 = in2[x] + string2
        break
    if int(in1[i]) > int(in2[i]):
        string1 = in1[i] + string1
    elif int(in1[i]) < int(in2[i]):
        string2 = in2[i] + string2
    elif int(in1[i]) == int(in2[i]):
        string1 = in1[i] + string1
        string2 = in2[i] + string2
    i += 1

if string1 == "":
    print("YODA")
    print(int(string2))
elif string2 == "":
    print(int(string1))
    print("YODA")
else:
    print(int(string1))
    print(int(string2))
