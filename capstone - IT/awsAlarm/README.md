# awsAlarm
aws configure can make enstance create alarms and upload to cloudwatch automated.
AWS configure need access_Key_id, secret key, region and output format. I don't know the aws account of school, so I make it manually when first time set up. Good news is just need to set up once :).
region should be something like us-east-1 and output format is text. 

1. The alarm.py will create sns with a topic named alarm.
2. You will receive an email to verify.This would enable your email to connect with aws alarm.
3. For now, We create 4 alarms:
name: cpu-alarm+%instance_id. It alarms when CPUUtilization's average value is over 70% within 2 evaluation periods.
name: cpu-CreditUsage+%instance_id. It alarms when CPUCreditUsage's average value is over 70% within 2 evaluation periods.
name: lb-mon+%instance_id. It alarms when Load Balancer Latency's average value exceeds 100s within 3 evaluation periods.
name: ebs-mon+%instance_id. It alarms when storage throughput's average value exceeds 100MB within 3 evaluation periods. 
