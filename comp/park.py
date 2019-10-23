import sys
day = 0

for lines in sys.stdin:
    user = lines.split()
    patrons = {}
    if user[0].upper() == "OPEN":
        day += 1
        for line in sys.stdin:
            H = line.split()
            if H[0].upper() == "ENTER":
                if not H[1] in patrons.keys():
                    patrons[H[1]] = -int(H[2])
                else:
                    patrons[H[1]] = patrons[H[1]] -int(H[2])
            elif H[0].upper() == "EXIT":
                patrons[H[1]] = patrons[H[1]] + int(H[2])
            elif H[0].upper() == "CLOSE":
                print("Day", day)
                for key in sorted(patrons):
                    print("%s: $%.2f" % (key, patrons[key]/10))
                print()
                break
