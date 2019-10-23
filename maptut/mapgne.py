import random

def create_map():
    cur = []
    for i in range(9):
        mapline = []
        for x in range(15):
            mapline.append(0)
        cur.append(mapline)
    x_pos = 0
    y_pos = len(cur)//2
    straight = 0
    count = 0
    while x_pos != 15:
        cur[y_pos][x_pos] = count
        movechance = random.randint(1,4)

        if movechance == 1:
            movement = random.randint(1,4)
            if movement == 1 and y_pos != len(cur)-1:
                count += 1
                if cur[y_pos+1][x_pos] != 1:
                    y_pos += 1
            elif movement == 2 and y_pos != 0:
                count += 1
                if cur[y_pos-1][x_pos] != 1:
                    y_pos -= 1
            elif movement == 3:
                count += 1
                x_pos += 1
    for k in cur:
        print(k)


create_map()