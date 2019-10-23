import gspread
from oauth2client.service_account import ServiceAccountCredentials


scope = ['https://spreadsheets.google.com/feeds']
creds = ServiceAccountCredentials.from_json_keyfile_name('secret.json', scope)
client = gspread.authorize(creds)

sheet = client.open('comments').sheet1

name = str(input("input your name and press enter: "))
comment = str(input("imput a comment and press enter: "))

row = [name, comment]
sheet.insert_row(row, 2)