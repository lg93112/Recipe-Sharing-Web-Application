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
  <title>Foodlicious</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
      .title {
          font-weight:bold;
          font-size:1.5em;
      }
  </style>
</head>
<body>

<div class="jumbotron text-center">
  <h1>This is the foodlicious site</h1>
  <?php
  $username=mysql_fetch_assoc($user);
  echo "<p>Welcome!"." "."$username[username]</p> ";
  ?>
   <a href='home.php'><h3>Begin our recipe hunting trip</h3></a>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h3 class="text-center title">Your Recipes:</h3>
      <?php
         while ($row = mysql_fetch_assoc($recipes)) {
         echo "<div class='col-sm-4'>";
          echo "<div class='col-sm-12 thumbnail'>";
         echo   "<div class='text-center title'>$row[title]" . "&nbsp" . "</div>";
         echo   "<div class='text-center'>Category: $row[category]</div>" ;
         echo   "<div class='text-center'>Tags: $row[tags]</div>" ;
         echo   "<div class='text-center'>Created On: $row[creationDate]</div>";
         echo   "<div class='text-center'>Calories: $row[calories] kCal</div>";
         echo   "<div class='text-center'><a href='view_recipe.php?id=$row[recipeId]&user=$current_user'>view</a>" . "  <a href='delete_recipe.php?id=$row[recipeId]'>delete</a></div>";
         echo "</div>";
         echo "</div>";
     }
      ?>
    </div>
    <div class="col-sm-12">
      <h3 class="text-center title">Your Reviews:</h3>
      <?php
         if(mysql_num_rows($reviews) > 0) {
             while ($row = mysql_fetch_assoc($reviews)) {
                 $recipe="SELECT title FROM Recipes WHERE recipeId='$row[recipeid]'";
        	     $title=mysql_fetch_assoc(mysql_query($recipe));
                 echo "<div>";
                 echo "Review for recipe: ". $title['title'] . "&nbsp"."<a href='view_recipe.php?id=$row[recipeid]&user=$current_user'>view</a>" . "  <a href='delete_review.php?id=$row[reviewid]'>delete</a>";
                 echo "</div>";
             }
        } else {
            echo "<div class='text-center'>Go start trying out, modifying, and reviewing any recipes that interest you</div>";
        }
      ?>
    </div>
    <div class="col-sm-12">
    <h3 class="text-center title">Recommendations:</h3>
    </div>
    <?php
      $result = json_decode(exec("python recommender_system.py $current_user"), true);
      $recipeid=$result['recipesid'];
      $ids = join("','",$recipeid);
      $sql = mysql_query("SELECT * FROM Recipes WHERE recipeId IN ('$ids')");
     while ($row = mysql_fetch_assoc($sql)){
         echo "<div class='col-sm-4'>";
         echo "<div class='col-sm-12 thumbnail'>";
         echo   "<div class='text-center title'>$row[title]</div>" ;
         echo   "<div class='text-center'>Category: $row[category]</div>" ;
         echo   "<div class='text-center'>Tags: $row[tags]</div>" ;
         echo   "<div class='text-center'>Created On: $row[creationDate]</div>";
         echo   "<div class='text-center'>Carlories: $row[calories]" . " kCal</div>";
         echo   "<div class='text-center'><a href='view_recipe.php?id=$row[recipeId]&user=$current_user'>View</a></div>";
         echo "</div>";
         echo "</div>";
     }
    ?>
  </div>
</div>


</body>
</html>