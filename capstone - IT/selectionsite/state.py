import boto3
string  = "<table>"
ec2 = boto3.resource('ec2')
for instance in ec2.instances.all():
    string += "<tr>"
    string += str(instance.id)  
    string += "          " + instance.state['Name']
    string += "</tr>"
string += "</table>"   

print(string)
