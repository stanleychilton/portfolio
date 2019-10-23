#!/usr/bin/python
import os
#count=0
#if (count==0):
p2 = os.popen("ec2metadata --instance-id")
ec2ID = p2.read().strip()
p1 = os.popen("sudo aws sns create-topic --name alarm")
arn = p1.read().strip()
region = arn[12:21]
#email = "1074623886@qq.com"
#os.system("aws sns subscribe --topic-arn %s --protocol email --notification-endpoint %s"%(arn,email)) # subscribe
os.system("sudo aws cloudwatch put-metric-alarm --alarm-name cpu-mon+%s --alarm-description 'Alarm when CPU exceeds 70 percent' --metric-name CPUUtilization --namespace AWS/EC2 --statistic Average --period 300 --threshold 70 --comparison-operator GreaterThanThreshold --dimensions  Name=InstanceId,Value=%s --evaluation-periods 2 --alarm-actions %s --unit Percent"%(ec2ID,ec2ID,arn))
os.system("sudo aws cloudwatch put-metric-alarm --alarm-name cpu-CreditUsage+%s --alarm-description 'Alarm when CPU Credit Usage exceeds 70 percent' --metric-name CPUCreditUsage --namespace AWS/EC2 --statistic Average --period 300 --threshold 70 --comparison-operator GreaterThanThreshold --dimensions  Name=InstanceId,Value=%s --evaluation-periods 2 --alarm-actions %s --unit Percent"%(ec2ID,ec2ID,arn))
os.system("sudo aws cloudwatch put-metric-alarm --alarm-name lb-mon+%s --alarm-description 'Alarm when Latency exceeds 100s' --metric-name Latency --namespace AWS/ELB --statistic Average --period 60 --threshold 100 --comparison-operator GreaterThanThreshold --dimensions Name=InstanceId,Value=%s --evaluation-periods 3 --alarm-actions %s --unit Seconds"%(ec2ID,ec2ID,arn))
os.system("sudo aws cloudwatch put-metric-alarm --alarm-name ebs-mon+%s --alarm-description 'Alarm when EBS volume exceeds 100MB throughput' --metric-name VolumeReadBytes --namespace AWS/EBS --statistic Average --period 300 --threshold 100000000 --comparison-operator GreaterThanThreshold --dimensions Name=InstanceId,Value=%s --evaluation-periods 3 --alarm-actions %s --insufficient-data-actions %s"%(ec2ID,ec2ID,arn,arn))
os.system("sudo aws cloudwatch put-metric-alarm --alarm-name cpu-monStop+%s --alarm-description 'Stop instance when CPU exceeds 70 percent' --metric-name CPUUtilization --namespace AWS/EC2 --statistic Average --period 300 --threshold 70 --comparison-operator GreaterThanThreshold --dimensions  Name=InstanceId,Value=%s --evaluation-periods 2 --alarm-actions arn:aws:automate:%s:ec2:stop --unit Percent"%(ec2ID,ec2ID,region))
