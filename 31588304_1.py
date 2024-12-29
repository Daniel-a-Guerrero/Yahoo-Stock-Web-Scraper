import requests
import re
import time

from bs4 import BeautifulSoup
from pymongo import MongoClient
client = MongoClient("mongodb://localhost:27017/")

dblist=client.list_database_names()
for sd in dblist:
    print(str(sd),end=", ")

db=client["stockBase"]
print(str(db))

dblist=client.list_database_names()
for sd in dblist:
    print(str(sd),end=", ")

col=db["Stocks"]
while(1):
    r = requests.get('https://finance.yahoo.com/most-active')
    rsc=r.status_code
    if rsc>=300 or rsc<=199:
        print("Can't connect. Retrying:")
        print(rsc)
        r=requests.get('https://finance.yahoo.com/most-active')
        rsc=r.status_code
        if rsc>=300 or rsc<=199:
            print("Retry failed")
            print(rsc)
            break
    print("Connection successful")
    soup1=BeautifulSoup(r.text, "lxml")
    h=soup1.html
    print(h.head.title.text)
    base=h.tbody
    #print("Name: "+base.name+"\tAttr: "+str(base.attrs))
    index=0
    for s in base.contents:
        symbol=s.contents[0].text
        print(symbol, end=", ")
        name=s.contents[1].text
        print(name, end=", ")
        price=float(s.contents[2].text)
        print(price, end=", ")
        change=float(s.contents[3].text)
        print(change, end=", ")
        vol=(s.contents[5].text)
        print(vol)
        if((str(col.find_one({"_id":index})))=="None"):
            col.insert_one({"_id":index, "Symbol":symbol, "Name":name, "Price":price, "Change":change, "Volume":vol})
        else:
            col.delete_one({"_id":index})
            col.insert_one({"_id":index, "Symbol":symbol, "Name":name, "Price":price, "Change":change, "Volume":vol})
        index+=1


    time.sleep(180)