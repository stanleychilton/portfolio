orgkey = 'abcdefghijklmnopqrstuvwxyz'
cipherkey = '@QEU45u6jgaw3i$^U?HWSA#*%!'

hashing_string = "the quick brown fox jumps over the lazy dog"

split = hashing_string.split()

full_string = ''

for i in split:
    full_string = full_string + " "
    for x in i:
        num = orgkey.index(x)
        full_string = full_string + cipherkey[num]

full_string = full_string[1:len(full_string)]

print(full_string)