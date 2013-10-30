<?php
$error = '';
if(isset($_POST['login'])) {
	session_start();
	$username = trim( $_POST['username'] );
	$password = sha1 ($username.$_POST['password'] );
	$userlist = 'encrypted.txt';
	$redirect = 'menu.php';
	require_once('inc/authenticate.inc.php');
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Title Goes Here</title>
</head>
<body>
<?php 
if($error!='') {
	echo '<p>' . $error . '</p>';
}
?>
<form id="form1" method="post" action="">
	<label for="username">Username:</label>
	<input type="username" name="username" id="username">
	<label for="password">Password:</label>
	<input type="password" name="password" id="password">
	<p>
	<input type="submit" name="login" value="login">
	</p>
</form>
</body>