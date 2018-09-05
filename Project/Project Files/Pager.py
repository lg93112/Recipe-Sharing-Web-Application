import urllib.request
import urllib.response
import urllib.error
import random
from nltk import tokenize
from bs4 import BeautifulSoup
from datetime import date,timedelta

def genCal(cat):
	if cat=='dessert':
		return random.randint(300,800)
	else:
		return random.randint(200,500)

def scrapeTasteMadeURL(baseUrl):
	html_data=None
	url2=urllib.request.Request(baseUrl)

	connect=urllib.request.urlopen(url2)
	with connect as html:
		html_data=html.read()

	soup=BeautifulSoup(html_data,"lxml")

	#Title extraction
	recipeTitle=soup.title.text
	recipeTitle=recipeTitle.replace('~ Recipe | Tastemade','')
	#print(recipeTitle)

	#Tags
	tagArray=[]
	tags=soup.find_all("a", class_="VideoInfoTag")
	for a in tags:
		tagArray.append(a.text)

	
	#Category
	intersect=list(set(['dinner','lunch','breakfast','dessert'])&set(tagArray))
	#print(intersect)

	if(len(intersect)==1):
		category=intersect[0]
	else:
		category="anytime"
	#print(category)

	#print(recipeTitle+"-"+category)
	#print(','.join(tagArray))

	#Instructions
	inst=soup.find_all("ol", class_="recipe-steps-list e-instructions")
	#print(len(inst))
	instructions=""
	for a in inst:
		instructions=a.text

	instructionArray=tokenize.sent_tokenize(instructions)
	trueInstructions=[str('Originally from '+baseUrl)+'.']+instructionArray


	#Ingredients
	ingredientArray=[]
	ing=soup.find_all("p", class_="p-ingredient")
	#print(len(ing))
	for a in ing:
		#print(line)
		ingredientArray.append(a.text)
	
	title='"'+recipeTitle+'"'
	cat='"'+category+'"'
	tags='"'+(', '.join(tagArray))+'"'
	ing='"'+(','.join(ingredientArray))+'"'
	inst='"'+(' '.join(trueInstructions))+'"'
	cal=genCal(category)

	resultString= "INSERT INTO `Recipes`(`title`,`category`,`ingredients`,`directions`,`tags`,`calories`) VALUES (%s,%s,%s,%s,%s,%d);" % (title,cat,ing,inst,tags,cal)
	return resultString




baseUrl="https://www.tastemade.com"

f=open('output.txt',"w+")
f2=open('tastemadelinks.txt',"r")
for line in iter(f2):
	res=scrapeTasteMadeURL(baseUrl+line)
	f.write(res+"\n")
f2.close()
f.close()


#VideoInfoTag=Tags
#p-ingredient=Ingredient
#recipe-steps-list e-instructions