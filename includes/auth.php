<?php 
session_start();
if((!isset($_SESSION['auth']) || !$_SESSION['auth']) && (isset($_SERVER['REQUEST_URI']) && !preg_match('/login\.php\?*.*$/', $_SERVER['REQUEST_URI'])))
	header('location: login.php?ref=' . preg_replace('/^\//', '', $_SERVER['REQUEST_URI']));
?>