import sqlite3
import sys
import cPickle
import sys

reload(sys)
sys.setdefaultencoding('utf8')
fin = open('../tf_idf.pkl')
p = cPickle.load(fin)
conn = sqlite3.connect('../3c.db3')
c = conn.cursor()

for x,y in p.items():
	for i,j in y:
		insert = "insert into tf_idf values('%s',%d,%f)"%(x,i,j)
		print insert
		c.execute(insert)
conn.commit()
conn.close()
fin.close()
