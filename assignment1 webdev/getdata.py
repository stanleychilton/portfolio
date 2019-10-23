from socket import *
import _thread
import xml.etree.ElementTree as et
import time
import json
import requests
import urllib.request
import shutil

tree = et.parse('status.xml')
root = tree.getroot()
root[-1].find("likes").text = str(int(root[-1].find("likes").text)+1)

tree.write('status.xml')