import re

dictionary = []

def displayDictionary():
    if len(dictionary) == 0:
        print("* The dictionary is empty *")
    else:
        print("* Known words ****\n")
        for i in dictionary:
            print("{:<13s} {:>s}".format(i[0], i[1]))


dictionary = [['the', 'la'], ['red', 'rosso'], ['is', "e'"], ['table', 'tavola']]


def lookup(word):
    for i in dictionary:
        if word == i[0]:
            return i[1]
        else:
            new = str(input("How do I translate " + word + ": "))
            list = [word, new]
            dictionary.append(list)
            return new


def main():
    while True:
        reply = input("Eng: > ")
        if reply == '?':
            displayDictionary()
        else:
            s = reply.lower()
            s = re.sub(r'[^\w\s]','',s)
            s = s.strip()
            words = s.split(" ")
            print(words)
            translatedReply = []
            for word in words:
                print(word)
                translation = lookup(word)
                translatedReply.append(translation)
            str1 = " ".join(translatedReply)
            print(str1.capitalize())


main()