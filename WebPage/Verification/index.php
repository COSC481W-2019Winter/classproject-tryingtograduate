<!doctype html>
<!Verification code>
<html>
	<head>
		<?php 
		session_start();
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
		?>
		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="../CSS/homeStyle.css">
	</head>
	<body>
		<h1 id = "Company" style = "text-align: center" > User Verification </h1>
		<div class = "center" style = "text-align: center">
			<form name="verify" action = "" method = "post">
			<b>A verification code has been sent to the email you provided.</b></br>  
			<b>Please enter the code below and click submit to verify your email.</b>
			</br></br>
			<label><br>Email:</label>
			<input id = "email" type="textbox" name="email" placeholder = "youremail@domain.com" />
			<label><br>Code:</label>
			<input id = "code" name = "code" type="textbox" name="code" placeholder = "######"/>
			</br><input id = "subCode" class = "button2" type = "submit" name = "subCode" value = "SUBMIT">
			</form>
		</div>
	</body>
</html>
<?php
	//check to see if SUBMIT button has been clicked		
	if(isset($_POST['subCode']))
	{
		//Variables needed to save the code entered
		$UserEmail = $POST['email'];
		$code = $_POST['code'];
		//query to check if code entered matches the verifyCode in same row as uniqueId of current user
		$result1 = mysqli_query($conn, "SELECT uniqueId from Person WHERE verifyCode = '$code' AND emailAddress = '$UserEmail'");
		echo '<script language="javascript">';
		echo 'alert("working after query but before checking rows!")';
		echo '</script>';
		//if query results in a row found
		if (mysqli_affected_rows($conn) > 0)
		{
			echo '<script language="javascript">';
			echo 'alert("Still working after checking rows but before deletions")';
			echo '</script>';
			//run query to update Person table with NULL values for verifyCode and ownerId for current user
			$query2 = "UPDATE Person SET ownerId = NULL, verifyCode = NULL WHERE verifyCode = '$code' AND emailAddress = '$UserEmail'";
			$result2 = $conn->query($query2);
			echo '<script language="javascript">';
			echo 'alert("Email Verified Successfully!")';
			echo '</script>';
			returnToHomepage();
		}
		else
		{
			echo '<script language="javascript">';
			echo 'alert("Code still needs troubleshooting")';
			echo '</script>';
		}
	}
//Close connection
$conn->close();
?>
