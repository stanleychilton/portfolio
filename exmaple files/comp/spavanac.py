H, M= map(int, input().split())

count = 0

while count != 45:
    count += 1
    M -= 1
    if H == 0 and M == 0:
        H = 23
        M = 60
    if M == 0:
        H -= 1
        M = 60


print(H, M)
