<?php
	//SignIn variables passed from html "name" field of input tag
	$username = filter_input(INPUT_POST, "username");
	$passWordEst = filter_input(INPUT_POST, "password");

	include ('../PHP/Database.php');
	// Create connection
	$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
	// Check connection

	//Sets a variable ($query) equal to the mysql query we want to run
	$query = "SELECT emailAddress FROM Person WHERE emailAddress = '$username'";

	//runs the query and stores the result in a variable called $result
	$result = $conn->query("$query");

	//tests the result to see if the query yielded any rows from our Person table
	if ($result->num_rows != 0)
		{
			//query and store query result in variable $queryHash then fetch stored password hash
			$queryHash = "SELECT passwordHash, uniqueId FROM Person WHERE emailAddress = '$username' AND ownerId IS NULL";
			$resultHash = $conn->query($queryHash);
			$resultHashRow = $resultHash->fetch_assoc();
			$hash = $resultHashRow['passwordHash'];
			$userId = $resultHashRow['uniqueId'];

			if (password_verify($passWordEst, $hash))
			{
				//routs the user to the Message Dashboard if username and password were found in same row of table
				echo $userId;
			}
			else
			{
				echo "0";
			}
		} else {
      echo "-1";
    }


	//Close connection
	$conn->close();
?>
