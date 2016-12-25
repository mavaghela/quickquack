<?php
	$dbconn = pg_connect("host=localhost dbname=llewell1 user=llewell1 password=51461") or die('Could not connect: ' . pg_last_error());
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');
	$reply=array();
	$username = $_SESSION['username'];
	$newPassword = $_REQUEST['pass'];

	if($newPassword == ""){
		$reply['status'] = "Password parameter empty";
	}

	//validate password
	else if(!preg_match('/^[\w-]*$/',$newPassword)) {
		$reply['status'] = 'Error: Invalid password';
	}

	else{

		//	updates user's password
		$query = pg_query($dbconn, "UPDATE users SET password='$newPassword' WHERE username='$username'");
		$reply['status'] = "Password successfully changed";
	}

	print json_encode($reply);
?>