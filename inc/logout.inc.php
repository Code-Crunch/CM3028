<?php
session_start();
ob_start();

if(!isset($_SESSION['authenticated'])) {
	header('Location: login.php');
	exit;
}
if(isset($_POST['logout'])) {
	//destroy the session variables
	$_SESSION = array();
	//unset the cookies
	if(isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400);
	}
	//destroy the session
	session_destroy();
	header('Location: login.php');
	exit;
}
?>