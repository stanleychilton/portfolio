import gspread, time, requests
from oauth2client.service_account import ServiceAccountCredentials

scope = ['https://spreadsheets.google.com/feeds']
creds = ServiceAccountCredentials.from_json_keyfile_name('files/secret.json', scope)
client = gspread.authorize(creds)

sheet = client.open('comments').sheet1

name = str(input("Input your name and press enter: "))
comment = str(input("Input a comment and press enter: "))

userip = (requests.get("http://jsonip.com/").json())["ip"]

result = int(sheet.cell(1,7).value)
sheet.update_cell(1,7, result+1)

print("writing to line", result+1)
print(result-1, "people have committed to this before you")

row = [name, comment, time.strftime("%H:%M:%S"), time.strftime("%d/%m/%Y"), time.strftime("%B"), userip]
print("please wait...")
sheet.insert_row(row, result+1)

print("thank you for your submission")

time.sleep(5)



























