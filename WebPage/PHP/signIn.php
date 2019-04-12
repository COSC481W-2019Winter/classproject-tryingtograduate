<?php
	//SignIn variables passed from html "name" field of input tag
	session_start();
	$username = filter_input(INPUT_POST, 'usernameEmail');
	$passWordEst = filter_input(INPUT_POST, 'passwordEst');
	$_SESSION['currentUserEmail'] = $username;

	//include files
	include ('../PHP/Database.php');
	include ('../PHP/Validation.php');

	// Create connection
	$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

	// Check connection
	if ($conn->connect_error)
	{
		echo "could not establish connection to db2...";
		die("Connection failed: " . $conn->connect_error);
	}

	//Sets aand run query then store in result
	$query = "SELECT emailAddress FROM Person WHERE emailAddress = '$username' AND ownerId IS NULL";
	$result = $conn->query("$query");

	//tests the result to see if the query yielded any rows from our Person table
	if ($result->num_rows != 0)
	{
		//query and store query result in variable $queryHash then fetch stored password hash
		$queryHash = "SELECT passwordHash FROM Person WHERE emailAddress = '$username' AND ownerId IS NULL";
		$resultHash = $conn->query($queryHash);
		$resultHashRow = $resultHash->fetch_assoc();
		$hash = $resultHashRow['passwordHash'];

		if (password_verify($passWordEst, $hash))
		{
			//routs the user to the Message Dashboard if username and password were found in same row of table
			echo '<script language="javascript">';
			echo 'window.location.href ="../dashboard"' ;
			echo '</script>';
		}
		else
		{
			//password not found, alert and return to home
			invlidUserOrPass();
		}
	}
	else
	{
		//username not found, alert and return to home.
		invlidUserOrPass();
	}

	//Close connection
	$conn->close();
?>
