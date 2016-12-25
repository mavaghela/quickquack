<?php

	// Ensures that user is not logged out when they refresh the page

	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');

	$reply=array();

	if(isset($_SESSION['username'])){
		$reply['status']='ok';
		$reply['username'] = $_SESSION['username'];
	}

	print json_encode($reply);

?>