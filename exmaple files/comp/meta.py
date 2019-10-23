import sys
d = {}
for line in sys.stdin:
	inp = line.split()
	if inp[0] == "define":
		d[inp[2]] = inp[1]
	elif inp[0] == "eval":
		try:
			if inp[2] == "=":
				print("true" if d[inp[1]] == d[inp[3]] else "false")
			else:
				s = d[inp[1]] + inp[2] + d[inp[3]]
				print(eval(s))
		except KeyError:
			print("undefined")
	