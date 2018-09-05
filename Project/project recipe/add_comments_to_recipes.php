<?php

 if(isset($_GET['id'])) {

 } else {echo "Nope";}

 $recipe = $_GET['var1'];
 $user=$_GET['var2'];
 $currentdate=date("Y-m-d");

 echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>";
 echo "<h1><i>Your Reviews for this recipe</i></h1><br>";
 echo "<form action='insert_reviews.php' method='post'>";
 echo "<div class='form-group'><label for='rating'>Rating:</label><input type='text'  name='rating'  placeholder=''></div>";
 echo "<div class='form-group'><label for='tag'>Tag:</label><input type='text'  name='tag'  placeholder=''></div>";
 echo "<div class='form-group'><label for='content'>Content:</label><textarea  name='content'  placeholder=''>Comments here</textarea></div>";
 echo "<input type='hidden' name='recipeid' value='$recipe' >";
 echo "<input type='hidden' name='userid' value='$user' >";
 echo "<input type='hidden' name='date' value='$currentdate' >";
 echo "<input type='submit' value='Submit'>";
 echo "</form>";
?>
