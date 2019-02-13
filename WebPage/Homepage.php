<!doctype html>
<!http://db2.emich.edu/~kbledsoe3/COSC481/Homepage.php>
<html>
	<head>
		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="homeStyle.css">
	<script></script>
	</head>

	
	
	<body>
		<h1 id = "Company" style = "text-align: center" > Carrier Pigeon </h1>
		<table id = "tables" class = "center" CELLPADDING="30" CELLSPACING="30">
			<td id = "outter1">
				<div id = "SI">
					<h3 style="text-align: center">Sign-In:</h3>
					<form id = "Sign-In" action = "" method = "post">
						<label><br>Username:</br></label>
						<input id = "usernameEmail" type="text" name="usernameEmail" placeholder = "Someone@domain.com" />
						<label><br>Password:</br></label>
						<input id = "passwordEst" type="password" name="passwordEst" placeholder = "Password"/>
						<input class = "button button1" type = "submit" name = "SignIn" value = "Sign-In" >
					</form>
				</div>
			</td>

			<td id = "outter2">
				<div id = "SU">
					<h3 class="center" style="text-align: center">Sign-Up:</h3>
					<form id = "Sign-Up" action = "" method = "post">
						<label><br>First Name:</br></label>
						<input id = "fname" type="text" name="fname" placeholder = "First Name" />
						<label><br>Last Name:</br></label>
						<input id = "lname" type="text" name="lname" placeholder = "Last Name" />
						<label><br>Email:</br></label>
						<input id = "email" type="text" name="email" placeholder = "somename@domain.com" />
						<label><br>Code:</br></label>
						<input id = "code" type="text" class = "resizedTextbox" name="code" placeholder = "####"/>
						<button class = "getCode" onclick="emailcode.html" >Get Code</button>
						<label><br>Password:</br></label>
						<input id = "passwordNew" type="password" name="passwordNew" placeholder = "Password"/>
						<label><br>Confirm:</br></label>
						<input id = "passwordNewCfm" type="password" name="passwordNewCnf" placeholder ="Password" />
						<label><br>Phone:</br></label>
						<input id = "phone" type="text" name="phone" placeholder = "###-###-####"/>
						<input class = "button button2" type = "submit" name = "SignUp" value = "Sign-Up" >
					</form>
				</div>
			</td>

		</table>
		</br></br>
	</body>
</html>
<?php
	//Variables created to access the database on Wi2017_436_kbledsoe3
    $servername = "localhost";
	$db_username = "kbledsoe3";     //Username for MySQL
	$db_password = "1784793b4a";     //Password for MySQL
	$db_name   = "Wi2017_436_kbledsoe3"; //Database name
	
	//Variables created to reference input textboxes, reference html by name 
	//SignUp Variables
	$fName = $_POST['fname'];
	$lName = $_POST['lname'];
	$eMail = $_POST['email'];
	$password = $_POST['passwordNew'];
	$phoneNum = $_POST['phone'];
	//SignIn Variables
	$username = $_POST['usernameEmail'];
	$passWordEst = $_POST['passwordEst'];
	
	// Create connection
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);
	// Check connection
	if ($conn->connect_error) 
	{
    	echo "could not establish connection to db2...";
		die("Connection failed: " . $conn->connect_error);	
	}
	else
	{
		echo "Connection Successful!!!!!";
		//output variables to make sure they are being stored properly
	}
	
	//Testing to see if the SignUp button has been pressed referenced by html name
	if(isset($_POST['SignUp']))	
	{
		//Test to see if the email entered already exists in the table
		$query = mysqli_query($conn, "SELECT emailAddress FROM Person WHERE emailAddress = '$eMail';");
		
		if ($query->num_rows != 0) //if username exists
		{
			echo '<script language="javascript">';
				echo 'alert("Email already registered.")';
				echo '</script>';
		}
		else //if email does not exist
		{
			//Inserts new record into table from sql statement
			mysqli_query($conn, "INSERT INTO Person(firstName, lastName, emailAddress, passwordHash, phoneNumber) 
				VALUES ('$fName', '$lName', '$eMail', '$password', '$phoneNum')");
			
			//Check the status of the query
			if (mysqli_affected_rows($conn) > 0)
			{
				echo '<script language="javascript">';
				echo 'alert("You have registered successfully!!")';
				echo '</script>';
			} 
			else 
			{
				echo "user not added";
			}
		}
	}
	//Testing to see if the SignIn button has been pressed referenced by html name
	if(isset($_POST['SignIn']))	
	{
		//Test to see if the email entered for the username exists in Person table
		$query = mysqli_query($conn, "SELECT emailAddress, passwordHash FROM Person 
		WHERE emailAddress = '$username' AND passwordHash = '$passWordEst';");
		//if username and password combination exists
		if ($query->num_rows != 0) 
		{
			echo '<script language="javascript">';
			echo 'alert("Welcome to Carrier Pigeon!!")';
			echo '</script>';
		}
		else
		{
			echo '<script language="javascript">';
			echo 'alert("User not found.")';
			echo '</script>';
		}
	}	
	
	
	//Close connection
	$conn->close();
?>