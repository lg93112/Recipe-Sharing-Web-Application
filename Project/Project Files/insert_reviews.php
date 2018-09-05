<?php  

$con = mysqli_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411', 'foodlicious_cs411', "3306");

  if (mysqli_connect_errno($con)) {
  	echo "Failed to connect " . mysqli_connect_error();
  	return false;
  }

 $rating=$_POST['rating'];
 $tag=$_POST['tag'];
 $content=$_POST['content'];
 $creationdate=$_POST['date'];
 $recipeid=$_POST['recipeid'];
 $userid=$_POST['userid'];

 $insert="INSERT INTO Reviews(recipeid, userid, rating, tag, content, creation_date)
          VALUES('$recipeid', '$userid', '$rating', '$tag', '$content', '$creationdate')";
          
$datecheck = "SELECT * FROM Recipes WHERE recipeId = $recipeid";

if(mysqli_query($con, $insert)) {
    if(strlen($content) > 250) {
        mysqli_query($con, "UPDATE Users SET reputation = reputation + 1 WHERE userid = $userid");
    }
}
	       
 mysqli_close($con);  
 header('Location: home.php');  
  exit(); 
?>