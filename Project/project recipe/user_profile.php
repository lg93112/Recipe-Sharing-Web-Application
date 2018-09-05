<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }

 $current_user=$_SESSION['user'];

 $user=mysql_query("SELECT * FROM Users WHERE userid='$current_user'");
 $recipes=mysql_query("SELECT * FROM Recipes WHERE userid='$current_user'");
 $reviews=mysql_query("SELECT * FROM Reviews WHERE userid='$current_user'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>This is the foodlicious site</h1>
  <?php
  $username=mysql_fetch_assoc($user);
  echo "<p>Welcome!"." "."$username[username]</p> ";
  ?>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <h3>Your Recipes:</h3>
      <?php
         while ($row = mysql_fetch_assoc($recipes)) {
         echo "<div>";
         echo $row['title'] ."&nbsp". "<a href='view_recipe.php?id=$row[recipeId]&user=$current_user'>view</a>" . "  <a href='delete_recipe.php?id=$row[recipeId]'>delete</a>";
         echo "</div>";
     }
      ?>
    </div>
    <div class="col-sm-4">
      <h3>Your Reivews:</h3>
      <?php
         while ($row = mysql_fetch_assoc($reviews)) {
         $recipe="SELECT title FROM Recipes WHERE recipeId='$row[recipeid]'";
	     $title=mysql_fetch_assoc(mysql_query($recipe));
         echo "<div>";
         echo "Review for recipe: ". $title['title'] . "&nbsp"."<a href='view_review.php?id=$row[reviewid]&user=$current_user'>view</a>" . "  <a href='delete_review.php?id=$row[reviewid]'>delete</a>";
         echo "</div>";
     }
      ?>
    </div>
    <div class="col-sm-4">
    <h3>Recommendations:</h3>        
    </div>
  </div>
</div>

<div class="jumbotron text-center">
 <a href='home.php'><h3>Begin our recipe hunting trip</h3></a>
 </div>

</body>
</html>