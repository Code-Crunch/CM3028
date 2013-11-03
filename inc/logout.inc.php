<?php
    /*
 	 * @author Marina Shchukina, 1014481@rgu.ac.uk
 	 */
    
	//destroy the session variables
	$_SESSION = array();
		
	//unset the cookies
	if(isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-86400);
	}
		
	//destroy the session
	session_destroy();
		
	header('Location: index.php');
	exit;
?>