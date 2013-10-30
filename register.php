<?php
if(isset($_POST['signup'])) {
	session_start();
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$repassword = trim($_POST['repassword']);
	$usersfile = 'encrypted.txt';
	
	include_once('inc/register_user_text.inc.php');

} 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Title Goes Here</title>
</head>
<body>
<h3>Register a new user</h3>
<?php if( isset($results) ) {
	echo '<ul>';
	foreach ($results as $key => $value) {
		echo '<li>' . $value . '</li>';
	}
	echo '</ul>';
} ?>

<form id="form2" method="post" action="">
	<label for="username">Username:</label>
	<input type="username" name="username" id="username">
	<label for="password">Password:</label>
	<input type="password" name="password" id="password">
	<label for="repassword">Retype password:</label>
	<input type="password" name="repassword" id="repassword">
	<p>
	<input type="submit" name="signup" value="Sign up">
	</p>
</form>
</body>