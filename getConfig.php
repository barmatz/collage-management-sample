<?php
require_once 'includes/ErrorCodes.php';
require_once 'includes/db.php';

$config = array();
$sql = 'select * from config';
$result = mysql_query($sql) or die(mysql_error());

if($result)
	while($row = mysql_fetch_object($result))
		$config[$row->key] = $row->value;
else
	throw new ErrorException(mysql_error(), ErrorCodes::SQL_ERROR);
?>