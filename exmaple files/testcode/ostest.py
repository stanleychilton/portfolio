import os

test = ["meme", "something", "test"]
something = ""
for i in test:
    something = os.path.join(something, i)
print(something)