<?php

	$link = mysql_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('foodlicious_cs411');

	$title=$_POST["search_title"];
	$ingredients=$_POST["search_ingredients"];
	$category=$_POST["search_category"];
	$tags=$_POST["search_tags"];
	$currentuser=$_POST["userid"];
	if(empty($title)){$title='';}
	if(empty($ingredients)){$ingredients='';}
	if(empty($category)){$category='';}
	if(empty($tags)){$tags='';}
	$sql="SELECT * FROM Recipes WHERE title LIKE '%$title%' AND ingredients LIKE '%$ingredients%' AND category LIKE '%$category%' AND tags LIKE '%$tags%'";
	$res=mysql_query($sql);
	if (mysql_num_rows($res)>0) 
	{
		print("<p>There are " . mysql_num_rows($res) . " result(s) available</p><br>");
		print("<h1><i>Recipes:</i></h1><br>");
		while($data=mysql_fetch_assoc($res))
		{
		$user="SELECT username FROM Users WHERE userid='$data[userid]'";
	    $username=mysql_fetch_assoc(mysql_query($user));
	    $reviews="SELECT * FROM Reviews WHERE recipeid='$data[recipeId]'";
	    $reviewssum=mysql_query($reviews);
		print("<p><b> recipeId: </b> {$data['recipeId']} <br>");
		print("<p><b> created by user: </b> {$username['username']} <br>");
	    print("<p><b> title: </b> {$data['title']} <br>");
	    print("<p><b> ingredients: </b> {$data['ingredients']} <br>");
        print("<p><b> category: </b> {$data['category']} <br>");
        print("<p><b> directions: </b> {$data['directions']} <br>");
        print("<p><b> tags: </b> {$data['tags']} <br>");
        print("<p><i><b>Reviews:</b></i><br>");
        while($review=mysql_fetch_assoc($reviewssum))
        {
         $user2="SELECT username FROM Users WHERE userid='$review[userid]'";
	 $username2=mysql_fetch_assoc(mysql_query($user2));
	 print("<p><b> comments by: </b> {$username2['username']}"."<b> created on: </b> {$review['creation_date']} <br>");
	 print("<p><b> rating: </b> {$review['rating']}"."<b> tags: </b> {$review['tag']} <br>");
	 print("<p><b> content: </b> {$review['content']} <br>");
        }
        echo "<div><a href='add_comments_to_recipes.php?var1=$data[recipeId]&var2=$currentuser'>Add Comments</a></div>";
        echo "<br><br>";
		}
	}
    else
    {
    	echo "No recipe found!";
    }

    echo "<div><a href='home.php'>Go Home</a></div>";
    
    mysql_close($link);
?>