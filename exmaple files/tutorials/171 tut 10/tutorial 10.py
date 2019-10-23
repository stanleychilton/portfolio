# item = {'title':'Toaster', 'cost':'79.95', 'brand': 'Vogels' }
#
# for i in item:
#     print(i, " - ",  item[i])
#
# item['cost'] = '49.95'
# print()
#
# for i in item:
#     print(i, " - ",  item[i])

# items = {}
#
#
# def getdetails():
#     d = {}
#     d['title'] = input(">>")
#     if d['title'].lower() == "quit":
#         return
#     d['cost'] = input(">>")
#     return d
#
#
# def fixcosts(d):
#     d['cost'] = float(d['cost'])
#     return d
#
#
# while True:
#     details = getdetails()
#     if details != None:
#         count = len(items)+1
#         items[details['title']] = details
#         print("The", details['title'], "was $" + details['cost'])
#     else:
#         break
#
# # for i in items:
# #     print(fixcosts(items[i]))
#
# ordered = sorted(items)
#
# print(items)
# print()
#
# for i in ordered:
#     print("The price of", items[i]['title'], "is $"+str(items[i]['cost']))

