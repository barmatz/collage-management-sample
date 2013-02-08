<?php
error_reporting(0);
session_start();

try 
{
	require_once 'includes/ErrorCodes.php';
	require_once 'includes/db.php';
	
	$json = array();
		
	$sql = 'select * from posts where enabled = 1';
	
	if(isset($_REQUEST['new']))
		$sql .= ' and new = 1 order by created desc';
	else if(isset($_REQUEST['old']))
		$sql .= ' and new = 0';
		
	$result = mysql_query($sql);
	if($result)
	{
		$json['posts'] = array();
		while($row = mysql_fetch_object($result))
			$json['posts'][] = $row;
	}
	else
		throw new ErrorException(mysql_error(), ErrorCodes::SQL_ERROR);
}
catch(Exception $error)
{
	$json['error'] = array(code => $error->getCode(), message => $error->getMessage());
}

header('content-type: application/json');

echo json_encode($json);
?>