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

 // select loggedin users detail
 $res=mysql_query("SELECT * FROM Users WHERE userid=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);
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
  <p>We find the best recipes for you</p>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-4">
    <h3>Create your own recipe</h3>
    <div id="newForm">
    <form action="insert.php" method="post">
      
      <div class="form-group">
          <label for="title">Title:</label>
          <input type="text"  name="title"  placeholder="">
      </div>
      
      <div class="form-group">
          <label for="">Category</label>
          <input type="text"  name="category" placeholder="">
      </div>
      
      <div class="form-group">
          <label for="">Tags</label>
          <input type="text"  name="tags"  placeholder="">
      </div>
      
      <div class="form-group">
          <label for="">Ingredients:</label>
          <textarea  name="ingredients"  placeholder="">Put your ingredients here</textarea>
      </div>
      
      <div class="form-group">
          <label for="">Directions:</label>
          <textarea  name="directions"  placeholder="">Directions</textarea>
      </div>
      
      <input type="submit" value="Add Recipe">

      <input type="hidden" name="userid" value="<?php echo $_SESSION["user"]; ?>" >
      
    </form>
    </div>
    </div>

    <div class="col-sm-4">
      <h3>Find desired recipes</h3>
      <div id="searchForm">
      <form action="search.php" method="post">
      
      <div class="form-group">
          <label for="title">Title:</label>
          <input type="text"  name="search_title"  placeholder="">
      </div>
      
      <div class="form-group">
          <label for="">Category</label>
          <input type="text"  name="search_category" placeholder="">
      </div>
      
      <div class="form-group">
          <label for="">Tags</label>
          <input type="text"  name="serach_tags"  placeholder="">
      </div>
      
      <div class="form-group">
          <label for="">Ingredients:</label>
          <input type="text"  name="search_ingredients"  placeholder="">
      </div>
      
      <input type="submit" value="Search Recipe">
      
      <input type="hidden" name="userid" value="<?php echo $_SESSION["user"]; ?>" >

      </form>
      </div>
    </div>

    <div class="col-sm-4">
      <h3>Look at our recipes</h3> 
      <?php
      $con = mysqli_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411', 'foodlicious_cs411', "3306");

      if (mysqli_connect_errno($con)) {
      echo "Failed to connect " . mysqli_connect_error();
      return false;
       }
  
      $select = "SELECT * FROM Recipes";
  
      $query = "SELECT * FROM Recipes";

      if ($result = mysqli_query($con, $query)) {

    /* fetch associative array */
      while ($row = mysqli_fetch_assoc($result)) {
         echo "<div>";
         echo $row['title'] . "  <a href='view_recipe.php?id=$row[recipeId]&user=$current_user'>view</a>" . "  <a href='delete_recipe.php?id=$row[recipeId]'>delete</a>";
         echo "</div>";
       }

    /* free result set */
      mysqli_free_result($result);
      }
      mysqli_close($con);
     ?>
    </div>
 </div>
</div>


<div class="jumbotron text-center">
<a href='user_profile.php'><h3>Go to your personal profile</h3></a>
<li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;<b>Sign Out</b></a></li>
</div>

</body>
</html>

<?php ob_end_flush(); ?>