<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
      
      ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    li {
        float: left;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
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
	
	    echo "<div class='container'>";
	    echo "<div class='row'>";
	    /* fetch associative array */
	    while ($row = mysqli_fetch_assoc($result)) {
	    	 $user="SELECT username FROM Users WHERE userid='$row[userid]'";
	         $username=mysqli_fetch_assoc(mysqli_query($con, $user));
	         $reviews="SELECT * FROM Reviews WHERE recipeid='$row[recipeId]'";
	         $reviewssum=mysqli_query($con, $reviews);
	         echo "<div class='col-sm-12 text-center'>";
	    	    echo "<h1>$row[title] recipe submitted by $username[username]</h1>";
	    	 echo "</div>";
	    
	         echo "<div class='col-sm-12 text-center'>";
	    	    echo "<h2>Category: $row[category] | Calories: $row[calories] kCal</h2>";
	    	 echo "</div>";
	    	 
	    	 echo "<div class='col-sm-12'>";
	    	       echo "<h3>Tags</h3>";
	    	 echo "</div>";
	    	 
	    	 $myTagString = $row['tags'];
	    	 $myTagArray = explode(',' , $myTagString);
	    	 echo "<ul class='list-group'>";
	    	 foreach($myTagArray as $myTagArray) {
	    	     echo "<li class='list-group-item'>$myTagArray</li>";
	    	 }
	    	 echo "</ul>";

	    	 
	    	 echo "<div class='col-sm-12'>";
	    	       echo "<h3>Ingredients</h3>";
	    	 echo "</div>";
	    	 
	    	 $myIString = $row['ingredients'];
	    	 $myIArray = explode(',' , $myIString);
	    	 echo "<ul class='list-group'>";
	    	 foreach($myIArray as $myIArray) {
	    	     echo "<li class='list-group-item'>$myIArray</li>";
	    	 }
	    	 echo "</ul>";
	    	 
	    	 echo "<div class='col-sm-12'>";
	    	       echo "<h3>Directions</h3>";
	    	 echo "</div>";
	    	 
	    	 echo "<div class='col-sm-12 thumbnail'>";
	    	    echo "<h4>$row[directions]</h4>";
	    	 echo "</div>";
	    	 
	    	  echo "<div class='col-sm-12 thumbnail'>";
	    	    echo "<div class='col-sm-4 text-center'>";
	    	        if($currentuser == $row['userid']) {
	    	            echo "<h4><a href='edit_recipe.php?id=$row[recipeId]'>Edit</a></h4>";
	    	        }
	    	    echo "</div>";
	    	    
	    	    echo "<div class='col-sm-4 text-center'>";
	    	        echo "<h4><a href='home.php'>Go Home</a></h4>";
	    	    echo "</div>";
	    	    
	    	    echo "<div class='col-sm-4 text-center'>";
	    	        if($currentuser != $row['userid']) {
	    	            echo "<h4><a href='add_comments_to_recipes.php?var1=$recipeid&var2=$currentuser'>Review</a></h4>";
	    	        }
	    	    echo "</div>";
	    	 echo "</div>";
	    	 
	    	 echo "<div class='col-sm-12'>";
	    	    echo "<h3>Reviews</h3>";
	    	 echo "</div>";
	    	 
	    	 while($review=mysqli_fetch_assoc($reviewssum))
             {
                 $user2="SELECT username FROM Users WHERE userid='$review[userid]'";
	         $username2=mysqli_fetch_assoc(mysqli_query($con, $user2));
	         echo "<div class='col-sm-12 thumbnail'>";
	    	    echo "<div class='col-sm-4 text-center'>";
	    	        echo "<h4><b>Reviewer: </b> {$username2['username']}</h4>";
	    	    echo "</div>";
	    	    
	    	    echo "<div class='col-sm-4 text-center'>";
	    	        echo "<h4><b> created on: </b> {$review['creation_date']}</h4>";
	    	    echo "</div>";
	    	    
	    	    echo "<div class='col-sm-4 text-center'>";
	    	        echo "<h4><b> rating: </b> {$review['rating']}</h4>";
	    	    echo "</div>";
	    	    
	    	    echo "<div class='col-sm-12'>";
	    	        echo "<h4><b> tags: </b> {$review['tag']} <br></h4>";
	    	    echo "</div>";
	    	    
	    	    echo "<div class='col-sm-12 '>";
	    	        echo "<div class='col-sm-12 thumbnail'>";
	    	        echo "<h4><b> content: </b> {$review['content']}</h4>";
	    	        echo "</div>";
	    	    echo "</div>";
	    	 echo "</div>";
	    	 
	         
	     }
	    }
	
	    /* free result set */
	    mysqli_free_result($result);
	}
	  mysqli_close($con);
		  	
?>
</body>
</html>
