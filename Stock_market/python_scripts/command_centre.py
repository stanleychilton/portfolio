import sell_stocks as ss

def time_until_end_of_day(dt=None):
    if dt is None:
        dt = datetime.now()
    return ((24 - dt.hour - 1) * 60 * 60) + ((60 - dt.minute - 1) * 60) + (60 - dt.second)

while True:
    from datetime import datetime
    from time import sleep
    now = datetime.now()
    dt_string = now.strftime("%H%M")
    print(dt_string)
    if "0130" > dt_string and dt_string < "0720":
        print("here")
        exec(open('buy_stocks.py').read())
        exec(open('purchased_stocks.py').read())
    else:
        ss.sell_all()
        #exec(open('pull_all_stocks.py').read())
        #exec(open('lowest_stocks.py').read())
        sleep_time = time_until_end_of_day()+5430
        print("sleeping for", sleep_time)
        if sleep_time <= 0:
            pass
        else:
            sleep(sleep_time)
        exec(open('updating_stocks.py').read())
