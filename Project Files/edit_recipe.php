<html>
    <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
      <style>
          body {
              font-family: 'Open Sans', sans-serif;
          }
          
          .box {
             border: 1px solid black;
             margin-bottom: 20px;
          }
          
          .title {
              font-weight: bold;
              font-size: 1.5em;
          }
          
          .row {
              display: flex;
              flex-wrap: wrap;
          }
          
          .hidden {
              display:none;
          }
      </style>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
        <div class="row">
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
    		     echo "<div class='col-sm-12 text-center'>";
    			     echo "<h1> You are currently updating $row[title]</h1>";
    			 echo "</div>";
    			 
    			 echo "<div class='col-sm-12'>";
		    	 echo "<form action='update_recipe.php' method='post'>";
		    	 echo "<div class='hidden'><input type='text' name='recipeId' value='$row[recipeId]' class='field left' readonly></div>";
		    	 echo "<div><label for='title'>Title:</label><input class='form-control' type='text'  name='title'  placeholder='' value='$row[title]'></div>";
    			 echo "<div><label for='category'>Category:</label><input class='form-control' type='text'  name='category'  placeholder='' value='$row[category]'></div>";
    			 echo "<div><label for='tags'>Tags:</label><input class='form-control' type='text'  name='tags'  placeholder='' value='$row[tags]'></div>";
    			 echo "<div><label for='ingredients'>Ingredients:</label><textarea class='form-control' name='ingredients'  placeholder=''>$row[ingredients]</textarea></div>";
    			 echo "<div><label for='directions'>Directions:</label><textarea class='form-control'  name='directions'  placeholder=''>$row[directions]</textarea></div>";
    			 echo "<div><label for='calories'>Calories:</label><input type='number' class='form-control'  name='calories'  value='$row[calories]' placeholder=''></div>";
		    	 echo "<input class='form-control' type='submit' value='Submit'>";
		    	 echo "</form>";
		    }
    		
    		    /* free result set */
    		    mysqli_free_result($result);
    		}
    		  mysqli_close($con);
    	?>
    	</div>
    	</div>
    </body>
	
	
	
</html>