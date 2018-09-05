import urllib.request
import urllib.response
import urllib.error
from bs4 import BeautifulSoup
from datetime import date,timedelta

baseUrl="https://www.tastemade.com/recipes?page="


#soup=BeautifulSoup(html_content,'html_parser')

#link=soup.find_all('div',attrs={'class':"fd-tile_fd-recipe "})
pageNum=1

f=open('tastemadelinks.txt','w+')
while pageNum<13:
	html_data=None
	url2=urllib.request.Request(baseUrl+str(pageNum))

	connect=urllib.request.urlopen(url2)
	with connect as html:
		html_data=html.read()
		soup=BeautifulSoup(html_data,"lxml")
		div_content = soup.find_all('a')
		for link in div_content:
			temp=link.get('href')
			if('/videos' in temp):
				f.write(temp+"\n")
	pageNum=pageNum+1

f.close()
#VideoInfoTag=Tags
#p-ingredient=Ingredient
#recipe-steps-list e-instructions