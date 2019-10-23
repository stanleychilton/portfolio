n = int(input())

t = input()
t = t.split()

x = set()
y = set()

for i in t:
	if i in x:
		y.add(i)
	else:
		x.add(i)
		
total = x.difference(y)

for z in range(len(t)):
	try:
		if t[z] == max(total):
			print(int(z)+1)
	except ValueError:
		print("none")
		break