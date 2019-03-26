<?php
	session_start();
	//SignIn variables passed from html "name" field of input tag
	$username = filter_input(INPUT_POST, 'usernameEmail');
	$passWordEst = filter_input(INPUT_POST, 'passwordEst');
	$_SESSION['currentUserEmail'] = $username;

	include ('../PHP/Database.php');
	// Create connection
	$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

	// Check connection
	if ($conn->connect_error)
		{
			echo "could not establish connection to db2...";
			die("Connection failed: " . $conn->connect_error);
		}
		
	//Sets a variable ($query) equal to the mysql query we want to run
	$query = "SELECT emailAddress FROM Person WHERE emailAddress = '$username'";

	//runs the query and stores the result in a variable called $result
	$result = $conn->query("$query");

	//tests the result to see if the query yielded any rows from our Person table
	if ($result->num_rows != 0)
		{
			//query and store query result in variable $queryHash then fetch stored password hash
			$queryHash = "SELECT passwordHash FROM Person WHERE emailAddress = '$username'";
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
				echo '<script language="javascript">';
				echo 'alert("Invalid password. Please enter a valid username and password.")';
				echo '</script>';
			}
		}
	else
		{
			//username and password not found in same row in Person table
			//display box stating the user was not found
			echo '<script language="javascript">';
			echo 'alert("User not found. Please enter a valid username and password.")';
			echo '</script>';
			//rerout the user from this php file back to homepage to try again
			echo '<script language="javascript">';
			echo 'window.location.href ="../home"' ;
			echo '</script>';
		}

	//Close connection
	$conn->close();
?>
