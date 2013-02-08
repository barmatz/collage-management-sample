<?php
$connection = mysql_connect('localhost', 'cmtmw', 'X0XWQzdnLNBnsVEy4Uh9') or die('connection error<br/>' . mysql_error());
if(!$connection)
	die('Failed to connect to database!');
$db = mysql_select_db('collage_management-the_marker-wall') or die('db error<br/>' . mysql_error());
if(!$db)
	die('Failed to select database!');

mysql_set_charset('UTF-8');
?>