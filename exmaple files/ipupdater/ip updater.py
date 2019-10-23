import gspread, time, requests
from oauth2client.service_account import ServiceAccountCredentials
from apscheduler.schedulers.blocking import BlockingScheduler


def update():
    print("used")
    scope = ['https://spreadsheets.google.com/feeds']
    creds = ServiceAccountCredentials.from_json_keyfile_name('details.json', scope)
    client = gspread.authorize(creds)
    sheet = client.open('ip_display').sheet1

    userip = (requests.get("http://jsonip.com/").json())["ip"]

    row = [userip, ]

    sheet.update_cell(2, 1, userip)
    sheet.update_cell(2, 2, time.strftime("%H:%M:%S"))


scheduler = BlockingScheduler()
job = scheduler.add_job(update, 'interval', minutes=1)

scheduler.start()