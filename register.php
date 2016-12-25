<?php
	
	$dbconn = pg_connect("host=localhost dbname=llewell1 user=llewell1 password=51461") or die('Could not connect: ' . pg_last_error());
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');

	$reply=array();

	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$firstName = $_REQUEST['firstName'];
	$lastName = $_REQUEST['lastName'];
	$email = $_REQUEST['email'];
	$confirmPass = $_REQUEST['confirmPass'];
	$bDay = $_REQUEST['bDay'];
	$bMonth = $_REQUEST['bMonth'];
	$bYear = $_REQUEST['bYear'];
	$gender = $_REQUEST['gender'];

	//validate First name
 	if(!(preg_match('/^[\w-]*$/',$firstName)) || $firstName == "") {		
		$reply['status'] = 'Error: Invalid First Name';
	}

	//validate Last name
	else if(!(preg_match('/^[\w-]*$/',$lastName)) || $lastName == "") {
		$reply['status'] = 'Error: Invalid Last Name';
	}

	//Validate email
	else if(!(preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/',$email)) || $email == "") {
		$reply['status'] = 'Error: Invalid email address';
	}

	//validate username
	else if(!(preg_match('/^[\w-]*$/',$username)) || $username == "") {
		$reply['status'] = 'Error: Invalid username';
	}

	//validate password
	else if(!(preg_match('/^[\w-]*$/',$password)) || $password == "") {
		$reply['status'] = 'Error: Invalid password';
	}


	//validate password confirmation
	else if(!(preg_match('/^[\w-]*$/', $confirmPass)) || $confirmPass == "") {
		$reply['status'] = 'Error: Invalid password confirmation';
	}

	//validate password confirmation
	else if($password != $confirmPass) {
		$reply['status'] = 'Error: Passwords do not match';
	}

	//validate Year
	else if(!(preg_match('/^[\d]{4}$/', $bYear)) || $bYear == "") {
		$reply['status'] = 'Error: Invalid Birth Year';
	}

	else{

		// query that adds new user to database
		$result = pg_query($dbconn, "INSERT INTO users (username, password, firstName, lastName, email, bDay, bMonth, bYear, gender) VALUES ('$username', '$password', '$firstName', '$lastName', '$email', '$bDay', '$bMonth', '$bYear', '$gender')");
		if($result){
			$SESSION['username'] = $username;
			$SESSION['firstName'] = $firstName;
			$SESSION['lastName'] = $lastName;
			$reply['status'] = 'ok';
		}

		else{
		 	$reply['status'] = 'Username already in use';
		 }
	}

	print json_encode($reply);

?>