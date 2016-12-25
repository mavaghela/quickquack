<?php

	$dbconn = pg_connect("host=localhost dbname=llewell1 user=llewell1 password=51461") or die('Could not connect: ' . pg_last_error());
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');

	// loads user's profile information from database
	
	$reply=array();
	$username = $_SESSION['username'];

	$query = pg_query($dbconn, "SELECT * FROM users WHERE username = '$username'");

	if($row = pg_fetch_row($query)){

		$reply['username'] = $row[0];
		$reply['firstname'] = $row[2];
		$reply['lastname'] = $row[3];
		$reply['email'] = $row[4];
		$reply['bDay'] = $row[5];
		$reply['bMonth'] = $row[6];
		$reply['bYear'] = $row[7];
		$reply['gender'] = $row[8];
	}

	print json_encode($reply);
?>