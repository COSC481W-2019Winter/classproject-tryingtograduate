<?php
	//SignUp Variables passed from html "name" field of input tag
	session start();
	$fName = filter_input(INPUT_POST, 'fname');
	$lName = filter_input(INPUT_POST, 'lname');
	$eMail = filter_input(INPUT_POST, 'email');
	$password = filter_input(INPUT_POST, 'passwordNew');
	$passwordCnf = filter_input(INPUT_POST, 'passwordNewCnf');
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$_SESSION['currentUserEmail'] = $eMail;
	$code = rand(0, 999999);
	$ownerId = 1;
	
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
		$query2 ="INSERT INTO Person(firstName, lastName, emailAddress, passwordHash, verifyCode, ownerId)
					VALUES ('$fName', '$lName', '$eMail', '$hash', '$code', '$ownerId')";

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
			
			//creates new group for verification email
			$query3 ="INSERT INTO Groups(groupName, ownerId) VALUES ('$code', '$ownerId');";
			$result3 = $conn->query($query3);
			
			//get group id
			$query4 = "SELECT groupId FROM Groups WHERE groupName = '$code' AND ownerId = '$ownerId';";
			$result4 = mysqli_query($conn, $query4);
			$row = $result4->fetch_assoc();
			$group_id = $row['groupId'];
			
			//get user id
			$query5 = "SELECT * FROM Person WHERE emailAddress='$eMail';";
			$result5 = mysqli_query($conn, $query5);
			$row = $result5->fetch_assoc();
			$user_id = $row['uniqueId'];
			
			//creates new Group_JT for verification email
			$query6 = "INSERT INTO Group_JT(groupOwnerId, groupId, contactId) VALUES ('$ownerId', '$group_id', '$user_id');";
			$result6 = mysqli_query($conn, $query6);
			
			//create message 
			$subject = "Carrier Pidgin Verification Code";
			$query7 = "INSERT INTO Message(ownerId, groupId, subject, content) VALUES ('$ownerId', '$group_id', '$subject', '$code');";
			$result7 = mysqli_query($conn, $query7);
			
			//insert into queue
			$results2 = mysqli_query($conn, "SELECT MAX(messageId) AS max FROM Message");
			if (mysqli_affected_rows($conn) > 0) //if rows are more than 0, max found in tables
			{
				$object2 = mysqli_fetch_assoc($results2);
				$msId = $object2['max'];
				//use the stored messageId to insert a job into the Queue
				mysqli_query($conn, "INSERT INTO Queue(messageId)VALUES ('$msId')");
			}
			
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
