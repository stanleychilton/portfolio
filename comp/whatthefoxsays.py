tests = int(input())
li = []
string = ""

for i in range(tests):
    sounds = input().split()
    while True:
        L = input()
        if L != "what does the fox say?":
            li.append((L.split())[2])
        else:
            break

    for items in li:
        count = 0
        for word in sounds:
            if items == word:
                sounds.pop(count)
            count += 1

    for i in sounds:
        string = string +" "+ i

print(string)
