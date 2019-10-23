orgkey = 'abcdefghijklmnopqrstuvwxyz'
cipherkey = '@QEU45u6jgaw3i$^U?HWSA#*%!'

hashed_string = '64ww$ #$?wU'

split = hashed_string.split()

full_string = ''

for i in split:
    full_string = full_string + " "
    for x in i:
        number = cipherkey.index(x)
        full_string = full_string + orgkey[number]


full_string = full_string[1:len(full_string)]

print(full_string)







hashed_string = 'hello world'

split = hashed_string.split()

full_string = ''

for i in split:
    full_string = full_string + " "
    for x in i:
        number = orgkey.index(x)
        full_string = full_string + cipherkey[number]


full_string = full_string[1:len(full_string)]

print(full_string)