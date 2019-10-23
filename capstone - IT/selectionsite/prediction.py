#!/usr/bin/env python3

import boto3
import datetime

    # Create a Cost Explorer client
client = boto3.client('ce')

response = client.get_cost_forecast(
    TimePeriod={
        'Start': '2019-10-05',
        'End': '2019-10-30'
    },
    Metric='BLENDED_COST',
    Granularity='MONTHLY'


)

amount = response['ForecastResultsByTime'][0]['MeanValue']
amount = float(amount)
lines = "${:,.2f}".format(amount)

print("Your predicted cost next month is: " + lines)
