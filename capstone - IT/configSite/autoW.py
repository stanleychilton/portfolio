#!/usr/bin/python
import os
file = open('/lib/systemd/system/rc.local.service','r') 
lines = [] 
for line in file:  
    lines.append(line) 
file.close() 
lines.insert(24, '[Install]\nWantedBy=multi-user.target\nAlias=rc-local.service') 
s = ''.join(lines) 
file = open('/lib/systemd/system/rc.local.service', 'w+') 
file.write(s) 
file.close() 
del lines[:] 
os.system("sudo ln -s /lib/systemd/system/rc.local.service /etc/systemd/system/rc.local.service") 
os.system("sudo touch /etc/rc.local") 
os.system("sudo chmod +x /etc/rc.local") 
fa = open('/etc/rc.local','w') 
fa.write("#!/bin/bash\nsudo python3 /home/ubuntu/configSite/cIp.py") 
#fa.write("\nsudo python3 /home/ubuntu/configSite/AutoCreateAlarm.py")
#fa.write("\nsudo python3 /home/ubuntu/configSite/once.py")
fa.close()
