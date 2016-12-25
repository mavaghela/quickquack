<?php
	
	$dbconn = pg_connect("host=localhost dbname=llewell1 user=llewell1 password=51461") or die('Could not connect: ' . pg_last_error());
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');

	$reply=array();

	$thumbs = $_REQUEST['vote'];
	$msgId = $_REQUEST['msgId'];

	// query that fetches number of "likes" on the quack	
	$query = pg_query($dbconn, "SELECT likes FROM yaks WHERE id='$msgId'");
	$row = pg_fetch_row($query);
	$likes = $row[0];

	$likes = $likes + $thumbs;
	// query adds a "like" or "dislike" on the quack
	$query = pg_query($dbconn, "UPDATE yaks SET likes='$likes' WHERE id='$msgId'");

	print json_encode($reply);

?>
