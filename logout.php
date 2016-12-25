<?php 

	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');
	
	$_SESSION=array();
	$reply = array();
	$reply['status'] = "login";

	print json_encode($reply);
?>