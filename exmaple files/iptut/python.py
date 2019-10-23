import gspread, time, requests
from oauth2client.service_account import ServiceAccountCredentials
from apscheduler.schedulers.blocking import BlockingScheduler

def update():
    print("update")
    scope = ['https://spreadsheets.google.com/feeds']
    creds = ServiceAccountCredentials.from_json_keyfile_name('details.json', scope)
    client = gspread.authorize(creds)
    sheet = client.open('ip_display').sheet1

    ip = (requests.get("http://jsonip.com/").json())["ip"]

    sheet.update_cell(2,1, ip)
    sheet.update_cell(2,2, time.strftime("%H:%M:%S"))

scheduler = BlockingScheduler()
job = scheduler.add_job(update, 'interval', hours=1)
scheduler.start()