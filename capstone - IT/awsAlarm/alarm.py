#!/usr/bin/python
import os
#os.system("sudo apt-get update")
#os.system("sudo apt-get -y install awscli")
#os.system("aws configure")
p2 = os.popen("ec2metadata --instance-id")
ec2ID = p2.read().strip()
p1 = os.popen("aws sns create-topic --name alarm")
arn = p1.read().strip()
region = arn[12:21]
email = input("please input an email which can receive emails for alarm:")
while True:
    choice = input("The email you type in is '%s'\nPlease confirm your email is correct or not(Y/N):"%(email))
    if choice == "Y" or choice == "y":
        break
    if choice == "N" or choice == "n":
        uu = input("please input an email which can receive emails for alarm:")
    else:
        print("please input Y or N")
print("Confirm and email is %s"%email)
os.system("aws sns subscribe --topic-arn %s --protocol email --notification-endpoint %s"%(arn,email))
os.system("aws cloudwatch put-metric-alarm --alarm-name cpu-mon+%s --alarm-description 'Alarm when CPU exceeds 70 percent' --metric-name CPUUtilization --namespace AWS/EC2 --statistic Average --period 300 --threshold 70 --comparison-operator GreaterThanThreshold --dimensions  Name=InstanceId,Value=%s --evaluation-periods 2 --alarm-actions %s --unit Percent"%(ec2ID,ec2ID,arn))
os.system("aws cloudwatch put-metric-alarm --alarm-name cpu-CreditUsage+%s --alarm-description 'Alarm when CPU Credit Usage exceeds 70 percent' --metric-name CPUCreditUsage --namespace AWS/EC2 --statistic Average --period 300 --threshold 70 --comparison-operator GreaterThanThreshold --dimensions  Name=InstanceId,Value=%s --evaluation-periods 2 --alarm-actions %s --unit Percent"%(ec2ID,ec2ID,arn))
os.system("aws cloudwatch put-metric-alarm --alarm-name cpu-monStop+%s --alarm-description 'Stop instance when CPU exceeds 70 percent' --metric-name CPUUtilization --namespace AWS/EC2 --statistic Average --period 300 --threshold 70 --comparison-operator GreaterThanThreshold --dimensions  Name=InstanceId,Value=%s --evaluation-periods 2 --alarm-actions arn:aws:automate:%s:ec2:stop --unit Percent"%(ec2ID,ec2ID,region))
os.system("aws cloudwatch put-metric-alarm --alarm-name lb-mon+%s --alarm-description 'Alarm when Latency exceeds 100s' --metric-name Latency --namespace AWS/ELB --statistic Average --period 60 --threshold 100 --comparison-operator GreaterThanThreshold --dimensions Name=InstanceId,Value=%s --evaluation-periods 3 --alarm-actions %s --unit Seconds"%(ec2ID,ec2ID,arn))
os.system("aws cloudwatch put-metric-alarm --alarm-name ebs-mon+%s --alarm-description 'Alarm when EBS volume exceeds 100MB throughput' --metric-name VolumeReadBytes --namespace AWS/EBS --statistic Average --period 300 --threshold 100000000 --comparison-operator GreaterThanThreshold --dimensions Name=InstanceId,Value=%s --evaluation-periods 3 --alarm-actions %s --insufficient-data-actions %s"%(ec2ID,ec2ID,arn,arn))
