<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<div id='container' align = "center">
			<h1>Create User</h1> 
			<form id="register" action="" method="post">
				<table id="newTable">
					<tr>
						<td> <span id="inLabel">Username:</span> </td>
  						<td> <input id="inBox" type="text" name="username" id="username"> </td>
  					</tr>
					<tr>
						<td> <span id="inLabel">First Name:</span> </td>
  						<td> <input id="inBox" type="text" name="fName" id="fName"> </td>
  					</tr>
					<tr>
						<td> <span id="inputLabel">Last Name:</span> </td>
  						<td> <input id="inBox" type="text" name="lName" id="lName"> </td>
  					</tr>
					<tr>
						<td> <span id="inLabel">Email Address:</span> </td>
  						<td> <input id="inBox" type="text" name="eMail" id="eMail"> </td>
  					</tr>
  					<tr>
  						<td> <span id="inLabel">Password:</span> </td>
  						<td> <input id="inBox" type="text" name="password" id="password"> </td>
  					</tr>
  				</table>
  				<br>
  				<input type="submit" name="submitButton" id="submitButton" value="Insert Record Into Table">
			</form>
		</div>
	</body>
</html>

<?php
	//Variables created to access the database on Wi2017_436_kbledsoe3
    $servername = "localhost";
	$db_username = "kbledsoe3";     //Username for MySQL
	$db_password = "1784793b4a";     //Password for MySQL
	$db_name   = "Wi2017_436_kbledsoe3"; //Database name
	
	//Variables created to reference input textboxes, reference html by name 
	$username = $_POST['username'];
	$fName = $_POST['fName'];
	$lName = $_POST['lName'];
	$eMail = $_POST['eMail'];
	$password = $_POST['password'];

	// Create connection
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);
		
	// Check connection
	if ($conn->connect_error) 
	{
    	die("Connection failed: " . $conn->connect_error);
	}
	
	//Test to see if table already exists. 
	$q = "SELECT id FROM User;";
	if($conn->query($q) == FALSE) 
	{
		//create table if none exists
		$run = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS User (
			id INT NOT NULL AUTO_INCREMENT,
			username VARCHAR(10),
			fName VARCHAR(30),
			lName VARCHAR(30),
			eMail VARCHAR(50),
			password VARCHAR(10),
			PRIMARY KEY(id)
			);");
		//show status
		if ($run == TRUE)
			{
				echo "table created";
			}
			else
			{
				echo "table was not created";
			}
	}
	//Testing to see if the submit button has been pressed referenced by name
	if(isset($_POST['submitButton']))
	{
		//Test to see if the username entered already exists in the table
		$query = mysqli_query($conn, "SELECT username FROM User WHERE username = '$username';");
		if ($query->num_rows != 0) //if username exists
		{
			echo "Username already exists";
		}
		else //if username does not exist
		{
			//Inserts new record into table from sql statement
			mysqli_query($conn, "INSERT INTO User(username, fName, lName, eMail, password) 
				VALUES ('$username', '$fName', '$lName', '$eMail', '$password')");
			
			//Check the status of the query
			if (mysqli_affected_rows($conn) > 0)
			{
				echo "New record created successfully";
			} 
			else 
			{
				echo "user not added";
			}
		}
	}
	//Close connection
	$conn->close();
?>
