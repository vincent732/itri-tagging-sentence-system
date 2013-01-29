# -*- coding: utf-8 -*-
import sqlite3
sentiment_dic = {0:'Positive',1:'Negative',2:'Neural'}
annotation_type = {0:'Product',1:'Comment'}

## connect db
conn = sqlite3.connect('Baby.seg.db')
c = conn.cursor()

sql = 'Select B.content,A.Type, A.Annotation from Comment_Note A, BabyHom_Comments_New B where A.CommentSn = cast(B.cid as Integer)'
c.execute(sql)
count = 0
for row in c:
    directory = annotation_type[int(row[1])]#Get type (Product or Comment)
    sentiment = sentiment_dic[int(row[2])]#Get sentiment (Positive Negative or Neural)
    fout = open('%s\%s.txt'%(directory,sentiment),'a')
    fout.write(row[0].encode('utf8')+"\n")
    fout.close()
    count+=1
    print 'Now handle %d to %s'%(count,directory+"/"+sentiment+".txt")
    print row[0]
