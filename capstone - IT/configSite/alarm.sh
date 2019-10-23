#!/bin/bash
sudo apt-get update
sudo apt-get -y install awscli
aws configure set aws_access_key_id
aws configure set aws_secret_access_key
aws configure set default.region us-east-1
ec2ID=$(ec2metadata --instance-id)
arn=us-east-1:119550322938:mytopic
aws cloudwatch put-metric-alarm --alarm-name cpu-mon+$ec2ID --alarm-description "Alarm when CPU exceeds 70%" --metric-name CPUUtilization --namespace AWS/EC2 --statistic Average --period 300 --threshold 70 --comparison-operator GreaterThanThreshold --dimensions  Name=InstanceId,Value=$ec2ID --evaluation-periods 2 --alarm-actions arn:aws:sns:$arn --unit Percent
aws cloudwatch put-metric-alarm --alarm-name lb-mon+$ec2ID --alarm-description "Alarm when Latency exceeds 100s" --metric-name Latency --namespace AWS/ELB --statistic Average --period 60 --threshold 100 --comparison-operator GreaterThanThreshold --dimensions Name=InstanceId,Value=$ec2ID --evaluation-periods 3 --alarm-actions arn:aws:sns:$arn --unit Seconds
aws cloudwatch put-metric-alarm --alarm-name ebs-mon+$ec2ID  --alarm-description "Alarm when EBS volume exceeds 100MB throughput" --metric-name VolumeReadBytes --namespace AWS/EBS --statistic Average --period 300 --threshold 100000000 --comparison-operator GreaterThanThreshold --dimensions Name=InstanceId,Value=$ec2ID --evaluation-periods 3 --alarm-actions arn:aws:sns:$arn --insufficient-data-actions arn:aws:sns:$arn
