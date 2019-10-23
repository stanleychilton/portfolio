n = input()
t = list(map(int, input().split()))

t.sort(reverse=True)

ma = 0
count  = 1
for i in range(len(t)):
    check = t[i]+count+1
    if check > ma:
        ma = check
    count += 1

print(ma)
