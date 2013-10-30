<?php
class CheckUsername {

	protected $_username;
	protected $_minimumChars;
	protected $_errors = array();

public function __construct($username, $minimumChars = 6) {
	$this->_username = $username;
	$this->_minimumChars = $minimumChars;
}
/*
 * Checks whether username has the minimum length
 */
public function check() {
	if (preg_match('/\s/', $this->_username)) {
		$this->_errors[] = 'Username should not contain spaces.';
	}
	if (strlen($this->_username) < $this->_minimumChars) {
		$this->_errors[] = "Username must be at least {$this->_minimumChars} characters.";
	}
	return $this->_errors ? false : true;
}
/*
 * Returns array of errors, in case any errors are found
 */
public function getErrors() {
	return $this->_errors;
}

}