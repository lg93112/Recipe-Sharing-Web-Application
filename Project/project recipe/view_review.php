<?php

     $con = mysqli_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411', 'foodlicious_cs411', "3306");

  	if (mysqli_connect_errno($con)) {
	  	echo "Failed to connect " . mysqli_connect_error();
	  	return false;
	  }
  

  	
  	$review = "SELECT * FROM Reviews WHERE reviewid=" . $_GET['id'];

  	$reviewid=$_GET['id'];
  	$currentuser=$_GET['user'];
  	

	    if ($result = mysqli_query($con, $review)) {
	
	    /* fetch associative array */
	    while ($row = mysqli_fetch_assoc($result)) {
	    	 $user="SELECT username FROM Users WHERE userid='$row[userid]'";
	         $username=mysqli_fetch_assoc(mysqli_query($con, $user));
	         $recipe="SELECT title FROM Recipes WHERE recipeId='$row[recipeid]'";
	         $title=mysqli_fetch_assoc(mysqli_query($con, $recipe));
                 echo "<p><b>Review for recipe:</b>"."&nbsp"."$title[title]</p>";
	    	 echo "<p><b>Created by:</b>"."&nbsp"."$username[username]</p>";
	    	 echo "<p><b>Rating</b>";
	    	 echo "<p>$row[rating]</p>";
	    	 echo "<p><b>Tag</b></p>";
	    	 echo "<p>$row[tag]</p>";
	    	 echo "<p><b>Content</b></p>";
	    	 echo "<p>$row[content]</p>";
	    	 echo "<p><b>Creation_Date</b><p>";
	    	 echo "<p>$row[creation_date]</p>";
	    	 echo "<div><a href='user_profile.php'>Go back</a></div>";
	    }
	
	    /* free result set */
	    mysqli_free_result($result);
	}
	  mysqli_close($con);
		  	
?>