<?php
  $json_payload = json_decode($_GET['json_payload']);
  $recipeid   = $json_payload['recipesid'];
 echo "<form name='form' action='/home/foodlicious/public_html/user_profile.php' method='post'>"
 echo "<input type='hidden' name='recommend' value='$recipeid'/>"
 echo "</form>"
?>