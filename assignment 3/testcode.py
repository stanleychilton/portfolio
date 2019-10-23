lst = [['a', 'b', 'c'], ['d', 'b', 'e', 'f'], ['g','h']]
list_no = 0
pos = 0
for x in range(0,len(lst)):
    try:
        pos = lst[x].index('e')
        break
    except:
        pass

list_no = x


print(list_no ,pos)