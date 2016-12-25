<?php
	
	$dbconn = pg_connect("host=localhost dbname=llewell1 user=llewell1 password=51461") or die('Could not connect: ' . pg_last_error());
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');

	$reply=array();

	$reply['username'] = $_REQUEST['username'];
	$reply['password'] = $_REQUEST['password'];

	$latitude = $_REQUEST['latitude'];
	$longitude= $_REQUEST['longitude'];

	$reply['latitude'] = $latitude;
	$reply['longitude'] = $longitude;

	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	if(($username == "") || ($password == "")){
		$reply['status']='Error: Username or Password not supplied';
	}

	//validate username
	else if(!preg_match('/^[\w-]*$/',$username)) {
		$reply['status'] = 'Error: Invalid username or password';
	}

	//validate password
	else if(!preg_match('/^[\w-]*$/',$password)) {
		$reply['status'] = 'Error: Invalid username or password';
	}

	else{
		$result = pg_query($dbconn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
		if($row = pg_fetch_row($result)){
			$_SESSION['username'] = $username;
			$_SESSION['latitude'] = $latitude;
			$_SESSION['longitude'] = $longitude;
			$reply['status'] = 'ok';

		}
		else{
			$reply['status'] = 'Incorrect username or password';
		}
	}

	print json_encode($reply);


?>