n = int(input())

for i in range(n):
    h = int(input())
    calc = h / 400
    if calc > h // 400:
        print(int(calc+1))
    else:
        print(int(calc))
