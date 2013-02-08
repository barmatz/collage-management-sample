<?php
error_reporting(0);
session_start();

try 
{
	require_once 'includes/ErrorCodes.php';
	require_once 'includes/db.php';
	
	$json = array();
	$authorized = false;

	if(isset($_REQUEST['user']) && isset($_REQUEST['pass']))
	{
		$sql = 'select user, permission from users where user = "' . $_REQUEST['user'] . '" and password = "' . sha1($_REQUEST['pass']) . '" and active = 1';
		$result = mysql_query($sql);
		
		if($result)
		{
			if(mysql_num_rows($result) > 0)
			{
				$authorized = true;
				$row = mysql_fetch_object($result);
				$permission = $row->permission;
				$_SESSION['auth'] = true;
				$_SESSION['user'] = array('name' => $row->user, 'permission' => $row->permission);
			}
			else
				throw new ErrorException('User not found', ErrorCodes::USER_NOT_FOUND);
		}
		else
			throw new ErrorException(mysql_error(), ErrorCodes::SQL_ERROR);
	}
	else 
		throw new ErrorException('Missing parameters', ErrorCodes::INCORRECT_NUMBER_OF_PARAMETERS);

	$json['authorized'] = $authorized;
}
catch(Exception $error)
{
	$json['error'] = array(code => $error->getCode(), message => $error->getMessage());
	$_SESSION['auth'] = false;
}

header('content-type: application/json');

echo json_encode($json);
?>