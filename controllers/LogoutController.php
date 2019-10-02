<?php
class LogoutController{

	public function __construct() {

	}

	public function run(){
		$_SESSION = array();

		session_destroy();

		# Redirect to the index
		header("Location: index.php");
		die();
	}

}
?>
