<?php 
    /*
 	 * @author Marina Shchukina, 1014481@rgu.ac.uk
 	 */
	$username = trim( $_POST['username'] );
	$password = sha1 ( $username.$_POST['password'] );
	
	if($username == $adminUsername && $password == $adminPassword ) {
		$_SESSION['currentUser'] = $username;
		if($username=='administrator') {
			$_SESSION['currentAccessLevel'] = 1; //for administrators	
		}
	} else {
		if ($username != $adminUsername) {
			array_push($error, 'Username is missing or invalid');
		}
		if ($password != $adminPassword) {
			array_push($error, 'Password is missing or incorrect');
	}
}
?>