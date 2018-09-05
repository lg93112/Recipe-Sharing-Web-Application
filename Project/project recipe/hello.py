#!/home/foodlicious/mypython/bin/python

activate_this_file = "/home/foodlicious/mypython/bin/activate_this.py"
execfile(activate_this_file, dict(__file__=activate_this_file))

import sys
currentuser=int(sys.argv[1])

import MySQLdb
import numpy as np
import numpy.ma as ma
import pandas as pd
import json

# We do this to ignore several specific Pandas warnings
import warnings
warnings.filterwarnings("ignore")


db = MySQLdb.connect("webhost.engr.illinois.edu", "foodlicious_cs411", "cs411", "foodlicious_cs411")
cursor = db.cursor()

recipeid=[]
title=[]
cursor.execute("SELECT * FROM Recipes")
results = cursor.fetchall()
for row in results:
	recipeid.append(row[0])
	title.append(row[6])
Recipes=pd.DataFrame({'recipeid':recipeid, 'title':title})

reviewid=[]
user=[]
recipeid2=[]
rating=[]
cursor.execute("SELECT * FROM Reviews")
results = cursor.fetchall()
for row in results:
	reviewid.append(row[0])
	recipeid2.append(row[1])
	user.append(row[2])
	rating.append(row[3])
Reviews=pd.DataFrame({'reviewid':reviewid, 'recipeid':recipeid2, 'user':user,'rating':rating})

reviewed_recipe=pd.merge(Recipes, Reviews)
print(reviewed_recipe.head())

# Make a pivot table containing ratings indexed by user id and recipeid
tmp_df = Reviews.pivot_table(index='user', columns='recipeid', values='rating')
tmp_df=tmp_df.fillna(0)
y = tmp_df.ix[currentuser].map(lambda x: 1 if x >= 3 else 0).tolist()
y = np.array(y)
tmp_df = tmp_df.drop(currentuser)
print(tmp_df.head())

the_data = tmp_df.applymap(lambda x: 1 if x >= 3 else 0).as_matrix()
print(the_data[:10])


def cosine_similarity(u, v):
    return(np.dot(u, v)/np.sqrt((np.dot(u, u) * np.dot(v, v))))

# The user-movie matrix
x = the_data
# Add a special index column to map the row in the x matrix to the userIds
tmp_df.tmp_idx = np.array(range(x.shape[0]))

# Compute similarity, find maximum value
sims = np.apply_along_axis(cosine_similarity, 1, x, y)
mx = np.nanmax(sims)
# Find the best matching user
usr_idx = np.where(sims==mx)[0][0]

print(y)
print(x[usr_idx])
print('\nCosine Similarity(y, x[{0:d}]) = {1:4.3f}' \
      .format(usr_idx, cosine_similarity(y, x[usr_idx])))

# Now we subtract the vectors
mov_vec = x[usr_idx]
# We want a mask aray, so we zero out any recommended movie.
mov_vec = [abs(val - 1) for val in mov_vec]
mov_vec = np.array(mov_vec)
print(mov_vec)

# Print out the number of recipes we will recommend.
print('\n{0} Recipe Recommendations for User = {1}' \
      .format(mov_vec[mov_vec == 0].shape[0], 
              tmp_df[tmp_df.tmp_idx == usr_idx].index[0]))

# Get the columns (recipeid) for the current user
mov_ids = tmp_df[tmp_df.tmp_idx == usr_idx].columns

# Now make a masked array to find recipes to recommend
# values are the recipeid, mask is the recipes the most
# similar user liked.
ma_mov_idx = ma.array(mov_ids, mask = mov_vec)
mov_idx = ma_mov_idx[~ma_mov_idx.mask] 

# Now make a DataFrame of the recipes of interest and display
mv_df = Recipes.ix[Recipes.recipeid.isin(mov_idx)].dropna()
recomm_recipeid=mv_df.recipeid

recomm_recipeid=list(mv_df.recipeid)
recomm_recipeid=",".join(map(str,recomm_recipeid))
print(recomm_recipeid)
ratingforrecipe=[]
userid=tmp_df[tmp_df.tmp_idx == usr_idx].index[0]
cursor.execute("SELECT rating FROM Reviews WHERE userid=userid AND recipeid IN %s",recomm_recipeid )
results = cursor.fetchall()
for row in results:
	ratingforrecipe.append(row[0])
mv_df['rating']=ratingforrecipe
mv_df= mv_df.sort_values(by='rating',ascending=False)

mv_df= mv_df.head(10)
print('Recipes you might like:')
print(60*'-')
for recipe in mv_df.title.values:
    print(recipe)
print(60*'-')

db.close()