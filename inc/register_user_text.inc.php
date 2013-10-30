<?php
require_once('lib/CheckUsername.php');
require_once('lib/CheckPassword.php');

	$checkPassword = new CheckPassword($password, $repassword, 4);
	$checkUsername = new CheckUsername($username);
	$results = array();

	$passwordOK = $checkPassword->check();
	$usernameOK = $checkUsername->check();

	if($passwordOK && $usernameOK) {
		$password = sha1($username.$password);

		//open the file in an append mode
		$users_file_handle = fopen($usersfile, 'a+');
		if(filesize($usersfile) === 0 ) { //if the file is clean
			fwrite($users_file_handle, "{$username},{$password}");
			array_push($results, 'Username registered successfully.');
		} else { //if there are already other usernames in the file
			rewind($users_file_handle);

			while( ($line = fgets($users_file_handle))!= false ) {
				
				$tmp = explode(',', $line);
				if($tmp[0] == $username) { //username is already on the list
					array_push($results, 'Username taken, please choose a different one');
					break;
				}
			}
			if(count($results) == 0) {
				fwrite($users_file_handle, PHP_EOL . "{$username},{$password}");
				array_push($results, 'Username registered successfully.');
				fclose($users_file_handle);
			}
		}
	} else { 
		$results = array_merge($results, 
			array_merge($checkUsername->getErrors(), $checkPassword->getErrors()) );
	}
	
?>