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
	  	
	
		if ($result = mysqli_query($con, $recipe)) {
		
		/* fetch associative array */
		while ($row = mysqli_fetch_assoc($result)) {
			 echo "<h1> You are currently updating $row[title]";
		    	 echo "<form action='update_recipe.php' method='post'>";
		    	 echo "<div><input type='text' name='recipeId' value='$row[recipeId]' class='field left' readonly></div>";
		    	 echo "<div><label for='title'>Title:</label><input type='text'  name='title'  placeholder='' value='$row[title]'></div>";
			 echo "<div><label for='category'>Category:</label><input type='text'  name='category'  placeholder='' value='$row[category]'></div>";
			 echo "<div><label for='tags'>Tags:</label><input type='text'  name='tags'  placeholder='' value='$row[tags]'></div>";
			 echo "<div><label for='ingredients'>Ingredients:</label><textarea  name='ingredients'  placeholder=''>$row[ingredients]</textarea></div>";
			 echo "<div><label for='directions'>Directions:</label><textarea  name='directions'  placeholder=''>$row[directions]</textarea></div>";
		    	 echo "<input type='submit' value='Submit'>";
		    	 echo "</form>";
		    }
		
		    /* free result set */
		    mysqli_free_result($result);
		}
		  mysqli_close($con);
	?>