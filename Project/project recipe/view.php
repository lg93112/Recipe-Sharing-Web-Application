<?php

        $con = mysqli_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411', 'foodlicious_cs411', "3306");

  	if (mysqli_connect_errno($con)) {
	  	echo "Failed to connect " . mysqli_connect_error();
	  	return false;
	  }
  
  	if(isset($_GET['id'])) {
  		
  	} else {
  		echo "Nope";
  	}
  	
  	$recipe = "SELECT * FROM Recipes WHERE recipeId=" . $_GET['id'];

  	$recipeid=$_GET['id'];
  	$currentuser=$_GET['user'];
  	

	    if ($result = mysqli_query($con, $recipe)) {
	
	    /* fetch associative array */
	    while ($row = mysqli_fetch_assoc($result)) {
	    	 $user="SELECT username FROM Users WHERE userid='$row[userid]'";
	         $username=mysqli_fetch_assoc(mysqli_query($con, $user));
	         $reviews="SELECT * FROM Reviews WHERE recipeid='$row[recipeId]'";
	         $reviewssum=mysqli_query($con, $reviews);
             echo "<h1>$row[title]</h1>";
	    	 echo "<p><b>Created by</b></p>";
	    	 echo "<p>$username[username]</p>";
	    	 echo "<p><b>Category</b>";
	    	 echo "<p>$row[category]</p>";
	    	 echo "<p><b>Tags</b></p>";
	    	 echo "<p>$row[tags]</p>";
	    	 echo "<p><b>Ingredients</b></p>";
	    	 echo "<p>$row[ingredients]</p>";
	    	 echo "<p><b>Directions</b><p>";
	    	 echo "<p>$row[directions]</p>";
	    	 print("<p><i><b>Reviews:</b></i><br>");
             while($review=mysqli_fetch_assoc($reviewssum))
             {
             $user2="SELECT username FROM Users WHERE userid='$review[userid]'";
	         $username2=mysqli_fetch_assoc(mysqli_query($con, $user2));
	         print("<p><b> comments by: </b> {$username2['username']}"."<b> created on: </b> {$review['creation_date']} <br>");
	         print("<p><b> rating: </b> {$review['rating']}"."<b> tags: </b> {$review['tag']} <br>");
	         print("<p><b> content: </b> {$review['content']} <br>");
	     }
	    	 echo "<div><a href='edit_recipe.php?id=$row[recipeId]'>edit</a></div>";
	    	 echo "<div><a href='add_comments_to_recipes.php?var1=$recipeid&var2=$currentuser'>Add Comments</a></div>";
	    	 echo "<div><a href='home.php'>Go Home</a></div>";
	    }
	
	    /* free result set */
	    mysqli_free_result($result);
	}
	  mysqli_close($con);
		  	
?>