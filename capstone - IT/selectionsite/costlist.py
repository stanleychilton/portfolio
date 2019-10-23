import sys, argparse, boto3, datetime

input1 = (sys.argv[1]).replace("/", "-")
input2 = (sys.argv[2]).replace("/", "-")

print(input1)

results = []
testheader = []
test = []

start = input1
end = input2

cd = boto3.client('ce')

if input1 == None or input2 == None:
	test.append("nothing")
	## expandable to be able to grab all data rather than just the
	## data between the selected time periods
	## script here to grab all data from the cost software
else:
	token = None
	while True:
		if token:
			kwargs = {'NextPageToken': token}
		else:
			kwargs = {}
		data = cd.get_cost_and_usage(TimePeriod={'Start': start, 'End':  end}, Granularity='DAILY', Metrics=['UnblendedCost'], GroupBy=[{'Type': 'DIMENSION', 'Key': 'LINKED_ACCOUNT'}, {'Type': 'DIMENSION', 'Key': 'SERVICE'}], **kwargs)
		results += data['ResultsByTime']
		token = data.get('NextPageToken')
		if not token:
			break
		
	print('\t'.join(['TimePeriod', 'LinkedAccount', 'Service', 'Amount', 'Unit', 'Estimated']))
	for result_by_time in results:
		for group in result_by_time['Groups']:
			amount = group['Metrics']['UnblendedCost']['Amount']
			unit = group['Metrics']['UnblendedCost']['Unit']
			test.append([result_by_time['TimePeriod']['Start'], '\t', '\t'.join(group['Keys']), '\t', amount, '\t', unit])

	
string  = "<table>"
for i in test:
    string += "<tr>"
    for x in i:
        if x != "\t":
            string += '<td>' + x + '</td>'
    string += "</tr>" ## formatting needs to be done here

string += "</table>"
print(string)  ## passes the string data back to the php script
