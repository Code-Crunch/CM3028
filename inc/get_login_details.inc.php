<?php
	/*
 	 * @author Marina Shchukina, 1014481@rgu.ac.uk
 	 */
	//reading the username and the encrypted password from a file 
	if(file_exists($loginDetails) && is_readable($loginDetails)) {
    	$users = file($loginDetails);
        $tmp = explode(',', $users[0]);
        $adminUsername = $tmp[0];
        $adminPassword = rtrim($tmp[1]);

	} else {
		array_push($error, "Can\'t find the login details");
	}
?>