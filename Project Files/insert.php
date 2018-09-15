<?php  
     $con = mysqli_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411', 'foodlicious_cs411', "3306");

  if (mysqli_connect_errno($con)) {
  	echo "Failed to connect " . mysqli_connect_error();
  	return false;
  }
  
  	  $title = $_POST['title'];
	  $ingredients =$_POST['ingredients'];
	  $directions =$_POST['directions'];
	  $category = $_POST['category'];
	  $tags = $_POST['tags'];
	  $calories = $_POST['calories'];
	  $userid=$_POST['userid'];
	
	$insert = "INSERT INTO Recipes (title, ingredients, directions, category, tags, creationDate, userid, calories)
		  VALUES ( '$title', '$ingredients', '$directions', '$category', '$tags', CURDATE(), '$userid', '$calories') ";
        
        if(mysqli_query($con, $insert)){
	} else{
	    	echo 'MySQL Error: ' . mysqli_error($con);
	}
	       
	  mysqli_close($con);
	  
	  header('Location: index.php');    
	  exit();
?>