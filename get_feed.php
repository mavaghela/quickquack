<?php
	$dbconn = pg_connect("host=localhost dbname=llewell1 user=llewell1 password=51461") or die('Could not connect: ' . pg_last_error());
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');
	$reply=array();
	$reply['messages']=array();

	$numQuacks = 0;
	$maxQuacks = 10;

	$type = $_REQUEST['type'];
	$rad = $_REQUEST['radius'];

	// converting radius to meters from km
	$radius = $rad * 1000;

	// getting user's longitude and latitude
	$longitudeUser = $_SESSION['longitude'];
	$latitudeUser = $_SESSION['latitude'];
	$username = $_SESSION['username'];

	if($type != 2){

		if($type){ // query that loads hot quacks
			
			$query = pg_query($dbconn, "SELECT msg, longitude, latitude, time, likes, id FROM (SELECT *, earth_distance(ll_to_earth('$latitudeUser', '$longitudeUser'), 
				ll_to_earth(yaks.latitude, yaks.longitude)) FROM yaks) q
				WHERE earth_distance < '$radius' ORDER BY likes DESC, time DESC");
		}

		else{ // query that loads new quacks
			$query = pg_query($dbconn, "SELECT msg, longitude, latitude, time, likes, id FROM (SELECT *, earth_distance(ll_to_earth('$latitudeUser', '$longitudeUser'), 
				ll_to_earth(yaks.latitude, yaks.longitude)) FROM yaks) q
				WHERE earth_distance <= '$radius' ORDER BY time DESC");
		}

		while ($numQuacks < $maxQuacks) { // sending feed from database to front end

			$data = pg_fetch_row($query);

			if($data == False){
				break;
			}

			$reply['messages'][$numQuacks]=$data;

			$numQuacks++;
		}

	}

	else{ // query that loads my quacks

		$query = pg_query($dbconn, "SELECT msg, longitude, latitude, time, likes, id FROM yaks WHERE yakuser='$username' ORDER BY time DESC");
		
		$data = pg_fetch_row($query);
		
		while($data != False){ // sends feed form database to front end
			$reply['messages'][$numQuacks]=$data;
			$data = pg_fetch_row($query);
			$numQuacks++;
		}
	}

	$reply['userLatitude'] = $latitudeUser;
	$reply['userLongitude'] = $longitudeUser;

	$reply['status'] = "ok";
	print json_encode($reply);

?>