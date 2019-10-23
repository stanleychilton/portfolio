N, W, H= map(int, input().split())

max = int(((W**2) + (H**2))**0.5)

for i in range(N):
    num = int(input())
    if num <= max:
        print("DA")
    else:
        print("NE")
