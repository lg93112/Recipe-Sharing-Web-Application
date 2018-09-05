<?php

	$link = mysql_connect('webhost.engr.illinois.edu', 'lg5_cs411', 'cs411');
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db('lg5_recipe');


	$recipeid=$_POST["recipeid"];
	$sql="SELECT * FROM recipe WHERE recipeid = '$recipeid' ORDER BY recipeid";
	$res=mysql_query($sql);
	$data=mysql_fetch_assoc($res);
	print("<p><b> recipeid: {$data['recipeid']} </b><br>");
	print("<p><b> ingredients: {$data['ingredients']} </b><br>")
?>