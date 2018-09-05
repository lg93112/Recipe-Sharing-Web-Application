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
      
      .header {
          font-weight: bold;
          font-size: 2em;
          margin-bottom: 1em;
      }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    
<?php

	$con = mysqli_connect('webhost.engr.illinois.edu', 'foodlicious_cs411', 'cs411', 'foodlicious_cs411', "3306");
        
    if (mysqli_connect_errno($con)) {
        echo "Failed to connect " . mysqli_connect_error();
        return false;
    }
          

	$title=$_POST["search_title"];
	$ingredients=$_POST["search_ingredients"];
	$category=$_POST["search_category"];
	$tags=$_POST["search_tags"];
	$calories = $_POST["search_calories"];
	$currentuser=$_POST["userid"];
	if(empty($title)){$title='';}
	if(empty($ingredients)){$ingredients='';}
	if(empty($category)){$category='';}
	if(empty($tags)){$tags='';}
	if(empty($calories)){$calories = 99999;}
	$sql="SELECT * FROM Recipes WHERE title LIKE '%$title%' AND category LIKE '%$category%' AND tags LIKE '%$tags%' AND calories <= $calories";
	
	$myIngredientArray = explode(',' , $ingredients);
    foreach($myIngredientArray as $mIA) {
        $sql .= " AND ingredients LIKE '%$mIA%'";
    }
    
    $myTagArray = explode(',', $tags);
    foreach($myTagArray as $mTA) {
        $sql .= " AND tags LIKE '%$mTA%'";
    }
    
    $sql .= " ORDER BY presence DESC";
	
	$result = mysqli_query($con, $sql);
	if (mysqli_num_rows($result) > 0) 
	{
        echo "<div class='container'>";
	    echo "<div class='row'>";
	    echo "<div class='text-center col-sm-12 header'>There are " . mysqli_num_rows($result) . " result(s) available | <a href='home.php'>Go Home</a></div>";
		while ($row = mysqli_fetch_assoc($result)) {
    
                 echo "<div class='col-sm-4'>";
                 echo "<div class='col-sm-12 thumbnail'>";
                 echo   "<div class='text-center title'>$row[title]</div>";
                 echo   "<div class='text-center'>Category: $row[category]</div>";
                 echo   "<div class='text-center'>Tags: $row[tags]</div>";
                 echo   "<div class='text-center'>Created On: $row[creationDate]</div>";
                 echo   "<div class='text-center'>Carlories: $row[calories]" . " kCal</div>";
                 echo   "<div class='text-center'><a href='view_recipe.php?id=$row[recipeId]&user=$current_user'>View</a></div>";
                 echo "</div>";
                 echo "</div>";
    
        }
        echo "</div>";
        echo "</div>";
        
            /* free result set */
              mysqli_free_result($res);
	}
    else
    {
    	echo "No recipe found!";
    }
    
    mysql_close($link);
?>

</body>
</html>