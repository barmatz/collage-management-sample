<?php
error_reporting(0);
session_start();

try 
{
	require_once 'includes/ErrorCodes.php';
	require_once 'includes/db.php';
	
	$json = array();

	if(isset($_REQUEST['id']) && isset($_REQUEST['enable']))
	{
		$sql = 'update posts set enabled = ' . ($_REQUEST['enable'] == 'true' ? 1 : 0) . ' where id = ' . $_REQUEST['id'];
		$result = mysql_query($sql);
		if(!$result)
			throw new ErrorException(mysql_error(), ErrorCodes::SQL_ERROR);
	}
	else 
		throw new ErrorException('Missing parameters', ErrorCodes::INCORRECT_NUMBER_OF_PARAMETERS);
		
	$json['success'] = true;
}
catch(Exception $error)
{
	$json['error'] = array(code => $error->getCode(), message => $error->getMessage());
}

header('content-type: application/json');

echo json_encode($json);
?>