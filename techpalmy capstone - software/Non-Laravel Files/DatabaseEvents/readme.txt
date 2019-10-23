Open your mysql server admin page. 
In your TechPalmy database click on the routines tab at the top right. 
Click add routine.
Name it OutofDate
Type is procedure, drop the parameters. Copy and paste in the code from the OutofDateprocedure.txt file. 
Click go at the bottom. 
Open the event tab at the top right.
Name it OutofDateCheck. 
Status = ENABLED. 
Event type = RECURRING. 
Exevute every 1, MINUTE.
Start at a time before the current time. Paste in contents of OutofDateCheckevent.txt file.
Click go. 
Go to C:\xampp\mysql\bin\my.ini
Paste in event_scheduler=ON under the [mysqld] heading. It's near the top. That should now all work :). 