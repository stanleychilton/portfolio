import boto3, sys

string  = "<table>"
ec2 = boto3.resource('ec2')

input1 = sys.argv[1]

for instance in ec2.instances.all():
    if str(instance.id) == input1:
        string += "<tr>"
        string += str(instance.id)  
        string += "          " + instance.state['Name']
        string += "</tr>"
string += "</table>"   

print(string)
