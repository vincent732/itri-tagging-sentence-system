#!/usr/bin/python
# -*- coding: utf-8 -*-
import cgi
#import cgitb; cgitb.enable()
import sqlite3
import os
import sys
import json
reload(sys)
sys.setdefaultencoding('utf8')
form = cgi.FieldStorage()
query = u'充'#form.getvalue('query')
query = query.decode('utf8')
result = {}
if query:
	conn = sqlite3.connect('3c.db3')
	c = conn.cursor()
	sql = 'select suggestion from auto_suggestion'%(query)
	c.execute(sql)
	result = {}
	count = 1
	for row in c:
		result[count] = row[0]
		count+=1
	conn.close()
else:
	result[1]=''
print "Content-Type: application/json\n"
print json.dumps(result)
