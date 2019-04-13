<?php
	//SignUp Variables passed from html "name" field of input tag
	$fName = filter_input(INPUT_POST, 'fname');
	$lName = filter_input(INPUT_POST, 'lname');
	$eMail = filter_input(INPUT_POST, 'email');
	$password = filter_input(INPUT_POST, 'passwordNew');
	$passwordCnf = filter_input(INPUT_POST, 'passwordNewCnf');
	$hash = password_hash($password, PASSWORD_DEFAULT);
	
	//create predefined messages
	$subject1 = "Weather Alert";
	$content1 = "Due to inclement conditions, some schedules may have changed.  Please check with your supervisor to confirm your shift.";
	$template1 = "Weather Alert";
	$subject2 = "Office Closure";
	$content2 = "The office will be closed today, Month Day Year.";
	$template2 = "Office Closure";
	$subject3 = "Staff Meeting";
	$content3 = "There will be a staff meeting at the end of shift today.  Attendance is required.";
	$template3 = "Staff Meeting";

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

	//check if password is acceptable.
	if (confirmPassword($password, $passwordCnf) && passwordValidation($password))
	{
		//Sets a variable ($query) equal to the mysql query we run to test for existing email in Person table
		$query = "SELECT emailAddress FROM Person WHERE emailAddress = '$eMail' AND ownerId IS NULL";

		//Sets a variable ($query2) equal to the mysql query we run to add a user to the Person table
		$query2 ="INSERT INTO Person(firstName, lastName, emailAddress, passwordHash)
					VALUES ('$fName', '$lName', '$eMail', '$hash')";

		//runs the query and stores the result in a variable called $result
		$result = $conn->query($query);

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
			$result2 = $conn->query($query2);

			//checks to see if the user was actually added to the Person table
			if (mysqli_affected_rows($conn) > 0)
			{
				//if successful, get ownerId from Person table
				$result3 = mysqli_query($conn, "SELECT MAX(uniqueId) AS max FROM Person");
				if (mysqli_affected_rows($conn) > 0){
					$object3 = mysqli_fetch_assoc($result3);
					$ownerId = $object3['max'];
				}
				
				//add predefined message to user's templates
				$query4 = mysqli_query($conn, "INSERT INTO Message(ownerId, subject, content, templateName)
				VALUES ('$ownerId', '$subject1', '$content1', '$template1');");
				$query5 = mysqli_query($conn, "INSERT INTO Message(ownerId, subject, content, templateName)
				VALUES ('$ownerId', '$subject2', '$content2', '$template2');");
				$query6 = mysqli_query($conn, "INSERT INTO Message(ownerId, subject, content, templateName)
				VALUES ('$ownerId', '$subject3', '$content3', '$template3');");

				// unset cookies
				if (isset($_SERVER['HTTP_COOKIE'])) {
					$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
					foreach($cookies as $cookie) {
						$parts = explode('=', $cookie);
						$name = trim($parts[0]);
						setcookie($name, '', time()-1000);
						setcookie($name, '', time()-1000, '/');
					}
				}

				//call email verification
				sendMail($eMail);
				
				//reroute user to verification
				redirectToVerificationPage();
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
