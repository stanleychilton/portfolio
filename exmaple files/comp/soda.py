e, f, c = map(int, input().split())
count = 0

f += e
while True:
    if f >= c:
        d = f//c
        count += d
        f = (f % c) + d
    else:
        break

print(count)
