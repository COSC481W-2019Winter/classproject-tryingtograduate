<!doctype html>
<!Verification code>
<html>
	<head>
		<?php 
		session_start();
		//include files
		include ('../PHP/Database.php');
		// Create connection
		$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
		// Check connection
		if ($conn->connect_error)
		{
			echo "could not establish connection to database";
			die("Connection failed: " . $conn->connect_error);
		}
		?>
		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="../CSS/homeStyle.css">
	</head>
	<body>
		<h1 id = "Company" style = "text-align: center" > User Verification </h1>
		<p id="messageAlert" style = "text-align: center"></p>
		<div class = "center" style = "text-align: center">
			<form name="verify" action = "" method = "post">
			<b>A verification code has been sent to the email you provided.</b></br>  
			<b>Please enter the code below and click submit to verify your email.</b>
			</br></br>
			<label><br>Email:</label>
			<input id = "email" type="textbox" class = "resizedTextbox2" name="email" placeholder = "youremail@domain.com" />
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
		$UserEmail = $_POST['email'];
		$code = $_POST['code'];
		
		//Regex for user inputs
		$emailRegex = "/^[.0-9A-Z_a-z]+@[.0-9A-Z_a-z]+.[a-zA-Z]{3}$/";
		$codeRegex = "/^[0-9]+$/";
		
		//check for valid input
		if (!preg_match($emailRegex, $UserEmail))
		{
			echo '<script language="javascript"> document.getElementById("messageAlert").innerHTML = "Invalid email" </script>';
		}
		else if (!preg_match($codeRegex, $code))
		{
			echo '<script language="javascript"> document.getElementById("messageAlert").innerHTML = "Invalid code entry" </script>';
		}
		else //if good input check for verification
		{
			//query to check if code entered matches the verifyCode in same row as uniqueId of current user
			$result1 = mysqli_query($conn, "SELECT uniqueId from Person WHERE verifyCode = '$code' AND emailAddress = '$UserEmail'");
			//if query results in a row found
			if ($result1->num_rows != 0) 
			{
				//run query to update Person table with NULL values for verifyCode and ownerId for current user
				$query2 = "UPDATE Person SET ownerId = NULL, verifyCode = NULL WHERE verifyCode = '$code' AND emailAddress = '$UserEmail'";
				$result2 = $conn->query($query2);
				echo '<script language="javascript">';
				echo 'alert("Email Verified Successfully!")';
				echo '</script>';
				echo '<script language="javascript">';
				echo 'window.location.href ="../home/index.html"';
				echo '</script>';
			}
			else
			{
				echo '<script language="javascript">';
				echo 'alert("Did not find email and code match. Please try again.")';
				echo '</script>';
				echo '<script language="javascript">';
				echo 'window.location.href ="../Verification/index.php"';
				echo '</script>';
			}
		}
	}
//Close connection
$conn->close();
?>
