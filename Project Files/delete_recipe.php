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
  	
	$delete = "DELETE FROM Recipes WHERE recipeId=" . $_GET['id'];
        
        if(mysqli_query($con, $delete)) {
	} else{
	    	echo 'MySQL Error: ' . mysqli_error($con);
	}
   

	mysqli_close($con);
	
	header('Location: index.php');    
	exit();
?>