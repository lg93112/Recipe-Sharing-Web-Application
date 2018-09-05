<html>
    <head>
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
        <div class='container'>
        <div class='row'>
        <?php

         $recipe = $_GET['var1'];
         $user=$_GET['var2'];
         $currentdate=date("Y-m-d");
         echo "<div class='col-sm-12'>";
            echo "<h1>Your Review for this recipe</h1>";
        echo "</div>";
        
        echo "<div class='col-sm-12'>";
         echo "<form action='insert_reviews.php' method='post'>";
         echo "<div class='form-group'><label for='rating'>Rating:</label><input class='form-control' type='text'  name='rating'  placeholder=''></div>";
         echo "<div class='form-group'><label for='tag'>Tag:</label><input class='form-control' type='text'  name='tag'  placeholder=''></div>";
         echo "<div class='form-group'><label for='content'>Content:</label><textarea class='form-control' name='content'  placeholder=''>Comments here</textarea></div>";
         echo "<input type='hidden' name='recipeid' value='$recipe' >";
         echo "<input type='hidden' name='userid' value='$user' >";
         echo "<input type='hidden' name='date' value='$currentdate' >";
         echo "<input class='form-control' type='submit' value='Submit'>";
         echo "</form>";
        echo "</div";
        
        ?>
        </div>
        </div>
    </body>
</html>


