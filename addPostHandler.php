<?php
error_reporting(0);
session_start();

try 
{
	require_once 'includes/ErrorCodes.php';
	require_once 'includes/db.php';
	
	$json = array();

	if(isset($_REQUEST['message']))
	{
		$fields = array();
		$values = array();
		
		setFieldAndValue('firstName', 'first_name');
		setFieldAndValue('lastName', 'last_name');
		setFieldAndValue('title', 'title');
		setFieldAndValue('message', 'message');
			
		$sql = 'insert into posts(' . implode(',', $fields) . ') values(' . implode(',', $values) . ')';
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

function setFieldAndValue($key, $sqlKey)
{
	global $fields, $values;
	if(isset($_REQUEST[$key]))
	{
		array_push($fields, $sqlKey);
		array_push($values, '"' . $_REQUEST[$key] . '"');
	}
}
?>