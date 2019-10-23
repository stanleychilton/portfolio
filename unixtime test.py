last_login = 1557962182
creation_time = 1518103712
current_unix_time = 1558014810

year = 31536000
month = 2592000
day = 86400
hour = 3600
minute = 60

time_since_login = current_unix_time - last_login
login = current_unix_time - last_login

years1 = 0
months1 = 0
days1 = 0
hours1 = 0
minutes1 = 0

while True:
    if login >= year:
        years1 += 1
        login -= year
    else:
        if login >= month:
            months1 += 1
            login -= month
        else:
            if login >= day:
                days1 += 1
                login -= day
            else:
                if login >= hour:
                    hours1 += 1
                    login -= hour
                else:
                    if login >= minute:
                        minutes1 += 1
                        login -= minute
                    else:
                        break

print(str(years1) + " " + str(months1) + " " + str(days1) + " " + str(hours1) + " " + str(minutes1))

time_since_login = (time_since_login/60)/60
print(time_since_login)



time = current_unix_time - creation_time

years = 0
months = 0
days = 0
hours = 0
minutes = 0

while True:
    if time >= year:
        years += 1
        time -= year
    else:
        if time >= month:
            months += 1
            time -= month
        else:
            if time >= day:
                days += 1
                time -= day
            else:
                if time >= hour:
                    hours += 1
                    time -= hour
                else:
                    if time >= minute:
                        minutes += 1
                        time -= minute
                    else:
                        break


print(str(years) + " " + str(months) + " " + str(days) + " " + str(hours) + " " + str(minutes))

time_since_creation = current_unix_time - creation_time
time_since_creation = ((time_since_creation/60)/60)/24
print(time_since_creation)