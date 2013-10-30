<?php
session_start();
if(!isset($_SESSION['authenticated'])) {
	header('Location: login.php');
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Title Goes Here</title>
</head>
<body>
<h3>Secret page</h3>
</body>