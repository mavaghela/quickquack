<?php
	$dbconn = pg_connect("host=localhost dbname=llewell1 user=llewell1 password=51461") or die('Could not connect: ' . pg_last_error());
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');
	$reply=array();

	$yakUser = $_SESSION['username'];
	$msg = $_REQUEST['message'];

	$longitude = $_SESSION['longitude'];
	$latitude = $_SESSION['latitude'];
	$zero = 0;


	if(preg_match("/^[a-zA-Z0-9 -!:)(;),#]*$/",$msg)){

		// query that adds quack to the database
		$query = pg_query($dbconn, "INSERT INTO yaks (yakuser, msg, longitude, latitude, likes) 
			VALUES ('$yakUser', '$msg', '$longitude', '$latitude', '$zero')");
	}

	if(!$query){
		$reply['status'] = "Error: Please try again";
	}

	else{
		$reply['status']='ok';
	}

	print json_encode($reply);
?>

