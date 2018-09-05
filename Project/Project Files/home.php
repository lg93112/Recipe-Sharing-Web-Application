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
  <title>Foodlicious</title>
  <meta charset="utf-8">
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
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>This is the foodlicious site</h1>
  <p>We find the best recipes for you</p>
  <a href='user_profile.php'><h3>Go to your personal profile</h3></a>
  <a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;<b>Sign Out</b></a>
</div>

<div class="container">
  <div class="row">
        <div class="col-sm-6">
        <h3>Create your own recipe</h3>
        <div id="newForm">
            <form action="insert.php" method="post">
              
              <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text"  name="title"  class="form-control" placeholder="">
              </div>
              
              <div class="form-group">
                  <label for="">Category: </label>
                  <select name="category" class="form-control">
                      <option value="Breakfast">Breakfast</option>
                      <option value="Lunch">Lunch</option>
                      <option value="Dinner">Dinner</option>
                      <option value="Dessert">Dessert</option>
                      <option value="Anytime">Anytime</option>
                    </select>
              </div>
              
              <div class="form-group">
                  <label for="">Tags</label>
                  <input class="form-control" type="text"  name="tags"  placeholder="Please seperate your tags with commas">
              </div>
              
              <div class="form-group">
                  <label for="">Ingredients:</label>
                  <textarea  class="form-control" name="ingredients"  placeholder="Please seperate your ingredients with commas ex.chicken,beef,pork"></textarea>
              </div>
              
              <div class="form-group">
                  <label for="">Directions:</label>
                  <textarea class="form-control" name="directions"  placeholder=""></textarea>
              </div>
              
              <div class="form-group">
                  <label for="">Calories:</label>
                  <input type="number" class="form-control" name="calories"  placeholder="">
              </div>
              
              <input class="btn btn-primary" type="submit" value="Add Recipe">
        
              <input type="hidden" name="userid" value="<?php echo $_SESSION["user"]; ?>" >
              
            </form>
        </div>
        </div>

    <div class="col-sm-6">
      <h3>Find desired recipes</h3>
      <div id="searchForm">
      <form action="search.php" method="post">
      
      <div class="form-group">
          <label for="title">Title:</label>
          <input class="form-control" type="text"  name="search_title"  placeholder="">
      </div>
      
      <div class="form-group">
          <label for="">Category: </label>
          <select name="search_category" class="form-control">
              <option value =""></option>
              <option value="Breakfast">Breakfast</option>
              <option value="Lunch">Lunch</option>
              <option value="Dinner">Dinner</option>
              <option value="Dessert">Dessert</option>
              <option value="Anytime">Anytime</option>
            </select>
      </div>
      
      <div class="form-group">
          <label for="">Tags</label>
          <input class="form-control" type="text"  name="search_tags"  placeholder="Please seperate your tags with commas">
      </div>
      
      <div class="form-group">
          <label for="">Ingredients:</label>
          <input class="form-control" type="text"  name="search_ingredients"  placeholder="Please seperate your ingredients with commas">
      </div>
      
      <div class="form-group">
          <label for="">Calories:</label>
          <input class="form-control" type="number"  name="search_calories"  placeholder="Input the number of calories you want the recipes to have less than or equal to">
      </div>
      
      <input class="btn btn-primary" type="submit" value="Search Recipe">
      
      <input type="hidden" name="userid" value="<?php echo $_SESSION["user"]; ?>" >

      </form>
      </div>
    </div>
    
            <div class="col-sm-12 text-center">
              <h3>Look at our recipes</h3> 
            </div>
            
              <?php
              $con = mysqli_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411', 'foodlicious_cs411', "3306");
        
              if (mysqli_connect_errno($con)) {
              echo "Failed to connect " . mysqli_connect_error();
              return false;
               }
          
          
              $query = "SELECT * FROM Recipes ORDER BY presence DESC";
        
              if ($result = mysqli_query($con, $query)) {
    
            $userAVG = mysqli_query($con, "SELECT AVG(reputation) as userAVG FROM (SELECT * FROM Users a1 WHERE (SELECT DATEDIFF(CURDATE(), creation_date)) > 7) a2");
            $userAVGData = mysqli_fetch_assoc($userAVG);
            

            /* fetch associative array */
              while ($row = mysqli_fetch_assoc($result)) {
                 $tempPresence = mysqli_query($con, "SELECT COUNT(*) as total FROM Reviews WHERE recipeid = $row[recipeId]");
                 $data = mysqli_fetch_assoc($tempPresence);
                 $ratingPresence = mysqli_query($con, "SELECT AVG(rating) as userRatings FROM (SELECT * FROM Reviews a2 WHERE recipeid = $row[recipeId]) a1");
                 $ratingAVGDATA = mysqli_fetch_assoc($ratingPresence);
                 $datePresence = mysqli_query($con, "SELECT DATEDIFF(CURDATE(), '$row[creationDate]') as datediff FROM Recipes WHERE recipeId = $row[recipeId]");
                 $datedata = mysqli_fetch_assoc($datePresence);
                 $userPresence = mysqli_query($con, "SELECT * FROM Users WHERE userid = $row[userid]");
                 $userdata = mysqli_fetch_assoc($userPresence);
                 $total = $ratingAVGDATA['userRatings'] * $data['total'] + min($datedata['datediff'], 30) + $userdata['reputation'] - $userAVGData['userAVG'];
                 mysqli_query($con, "UPDATE Recipes SET presence = $total WHERE recipeId = $row[recipeId]");
                 
                 
                 
                 
                 
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

            /* free result set */
              mysqli_free_result($result);
              }
              mysqli_close($con);
             ?>

 </div>
</div>

</body>
</html>

<?php ob_end_flush(); ?>