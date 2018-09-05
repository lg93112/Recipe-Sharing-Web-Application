#!/home/foodlicious/mypython/bin/python

activate_this_file = "/home/foodlicious/mypython/bin/activate_this.py"
execfile(activate_this_file, dict(__file__=activate_this_file))

import sys
import numpy as np
import numpy.ma as ma
import MySQLdb
import pandas as pd
import warnings
import json
import requests
from current_user import currentuser
warnings.filterwarnings("ignore")

currentuser=currentuser()

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

# Make a pivot table containing ratings indexed by user id and recipeid
tmp_df = Reviews.pivot_table(index='user', columns='recipeid', values='rating')
tmp_df=tmp_df.fillna(0)
y = tmp_df.ix[currentuser].map(lambda x: 1 if x >= 3 else 0).tolist()
y = np.array(y)
tmp_df = tmp_df.drop(currentuser)

the_data = tmp_df.applymap(lambda x: 1 if x >= 3 else 0).as_matrix()

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

# Now we subtract the vectors
mov_vec = x[usr_idx]
# We want a mask aray, so we zero out any recommended movie.
mov_vec = [abs(val - 1) for val in mov_vec]
mov_vec = np.array(mov_vec)


# Get the columns (recipeid) for the current user
mov_ids = tmp_df[tmp_df.tmp_idx == usr_idx].columns

# Now make a masked array to find recipes to recommend
# values are the recipeid, mask is the recipes the most
# similar user liked.
ma_mov_idx = ma.array(mov_ids, mask = mov_vec)
mov_idx = ma_mov_idx[~ma_mov_idx.mask] 

# Now make a DataFrame of the recipes of interest and display
mv_df = Recipes.ix[Recipes.recipeid.isin(mov_idx)].dropna()
mv_df= mv_df.head(10)
recipe=list(mv_df.recipeid)
data={'recipesid':recipe}
data_json = json.dumps(data)
print data_json

db.close()