<?php  
        $con = mysqli_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411', 'foodlicious_cs411', "3306");

  if (mysqli_connect_errno($con)) {
  	echo "Failed to connect " . mysqli_connect_error();
  	return false;
  }
  	  $id = $_POST['recipeId'];
  	  $title = $_POST['title'];
	  $ingredients =$_POST['ingredients'];
	  $directions =$_POST['directions'];
	  $category = $_POST['category'];
	  $tags = $_POST['tags'];
	  $calories = $_POST['calories'];
	  
	
	  $update = "UPDATE Recipes
		   SET title = '$title', ingredients = '$ingredients', directions = '$directions', tags = '$tags', category = '$category', calories = '$calories'
		   WHERE recipeId='$id'";
        
          if(mysqli_query($con, $update)){
	} else{
	    	echo 'MySQL Error: ' . mysqli_error($con);
	}
		       
    $userId = mysqli_query($con, "SELECT * FROM Recipes WHERE recipeId = $id");
    $userData = mysqli_fetch_assoc($userId);
	       
	  header("Location: view_recipe.php?id=" . $id . "&user=" . $userData['userid']);
	  exit();     
	       
	  mysqli_close($con);

?>