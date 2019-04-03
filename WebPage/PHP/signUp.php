<?php
	//SignUp Variables passed from html "name" field of input tag
	$fName = filter_input(INPUT_POST, 'fname');
	$lName = filter_input(INPUT_POST, 'lname');
	$eMail = filter_input(INPUT_POST, 'email');
	$password = filter_input(INPUT_POST, 'passwordNew');
	$passwordCnf = filter_input(INPUT_POST, 'passwordNewCnf');
	$phoneNum = filter_input(INPUT_POST, 'phone');
	$hash = password_hash($password, PASSWORD_DEFAULT);
	
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
	
	//check if password is acceptable.
	if (confirmPassword($password, $passwordCnf) && passwordValidation($password))
	{
		//Sets a variable ($query) equal to the mysql query we run to test for existing email in Person table
		$query = "SELECT emailAddress FROM Person WHERE emailAddress = '$eMail'";
		
		//Sets a variable ($query2) equal to the mysql query we run to add a user to the Person table
		$query2 ="INSERT INTO Person(firstName, lastName, emailAddress, passwordHash, phoneNumber) 
					VALUES ('$fName', '$lName', '$eMail', '$hash', '$phoneNum')";
					
		//runs the query and stores the result in a variable called $result
		$result = $conn->query("$query");
		
		//tests the result to see if the query yielded any rows from Person table that match the email entered
		if ($result->num_rows != 0) 
		{
			//if email already exists in Person table, user is alerted
			echo '<script language="javascript">';
			echo 'alert("Email already registered.")';
			echo '</script>';
			
			//rerout the user from this php file back to homepage to try again
			returnToHomepage();
		}
		else  //if no matching email exists, run second query
		{
			//runs the second query and stores the result in $result2
			$result2 = $conn->query("$query2");
			
			//checks to see if the user was actually added to the Person table
			if (mysqli_affected_rows($conn) > 0)
			{
				//alerts user of successful registration 
				echo '<script language="javascript">';
				echo 'alert("You have registered successfully!!")';
				echo '</script>';
				
				//rerouts user to homepage to sign in with new credentials
				returnToHomepage();
			}
			else
			{
				echo '<script language="javascript">';
				echo 'alert("Something went wrong!!")';
				echo '</script>';
			}	
		}
	}
	
	//Close connection
	$conn->close();
?>

