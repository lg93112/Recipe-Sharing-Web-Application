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

if(mysqli_query($con, $insert)){
	} else{
	    	echo 'MySQL Error: ' . mysqli_error($con);
	}
	       
 mysqli_close($con);  
 header('Location: home.php');  
  exit(); 
?>