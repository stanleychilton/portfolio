for e in range(1, 1000):
    for f in range(1,1000):
        for c in range(2,2000):
            count = 0
            print ("test start")
            print (e,f,c)
            f += e
            while e != 0 or f < c:

                if f >= c:
                    d = f//c
                    count += d
                    f = (f % c) + d
                else:
                    break

            print(count)
