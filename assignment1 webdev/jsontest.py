import json

name = "new test"
ip = "87945612378945"

file = open("friends.json", "r")
text = file.readline()

data = json.loads(text)

print(data)

new_data = {}
new_data["name"] = name
new_data["properties"] = {}
new_data["properties"]["ip"] = ip

data["friends"].append(new_data)

print(data)

with open("friends.json", "w") as f:
    json.dump(data, f)