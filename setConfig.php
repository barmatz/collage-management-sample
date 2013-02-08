<?php
require_once 'includes/db.php';

foreach($_POST as $key=>$value)
	mysql_query('update config set `value` = ' . $value . ' where `key` = "' . $key . '"');
?>