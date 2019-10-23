while True:
    n = int(input(""))
    if n == 0:
        break
    list = []

    p = 1

    #print(n)

    for i in str(n):
        list.append(int(i))

    total = sum(list)

    while True:
        del list[:]
        num = n * p
        for x in str(num):
            list.append(int(x))
        if sum(list) == total and p > 10:
            break
        p += 1

    print(p)


