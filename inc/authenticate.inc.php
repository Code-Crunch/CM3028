<?php

if(!file_exists($userlist) || !is_readable($userlist)) {
	$error = 'Problem with a file';
} else {
	$users = file($userlist);
	
	for ($i = 0; $i < count($users); $i++) {
		
		// separate each element and store in a temporary array
		$tmp = explode(',', $users[$i]);

		// check for a matching record
		if ($tmp[0] == $username && rtrim( $tmp[1] ) == $password ) {
			$_SESSION['authenticated'] = 'Code Crunch';
			session_regenerate_id();
			break;
		}
	}
	
	if( isset( $_SESSION['authenticated']) ) {
		header('Location: menu.php');
		exit;
	} else {
		$error = 'Username of password are incorrect';
	}
}
?>