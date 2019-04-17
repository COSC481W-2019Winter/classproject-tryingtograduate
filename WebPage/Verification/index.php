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
			<form>
			<b>A verification code has been sent to the email you provided.</b></br>  
			<b>Please enter the code below and click submit to verify your email.</b>
			</br></br>
			<label><br>Email:</label>
			<input id = "email" type="textbox" name="email" placeholder = "youremail@domain.com" />
			<label><br>Code:</label>
			<input id = "code" name = "code" type="textbox" name="code" placeholder = "######"/>
			</br><input id = "subCode" class = "button2" type = "submit" name = "subCode" onclick="removeday()" value = "SUBMIT">
			</form>
		</div>
	</body>
</html>
<?php
	//Variables needed to save the code entered
	$UserEmail = $POST['email'];
	$code = $_POST['code'];
	//check to see if SUBMIT button has been clicked		
	if(isset($_POST['subCode']))
	{
		//query to check if code entered matches the verifyCode in same row as uniqueId of current user
		$query1 = "SELECT uniqueId from Person WHERE verifyCode = '$code' AND emailAddress = '$userEmail'";
		$result1 = $conn->query($query1);
		//extract $niqueId to use in next query
		$id1 = mysqli_fetch_object($result1);
		$UniqueId = $id1->uniqueId;
		
		//if query results in a row found
		if ($result1->num_rows != 0)
		{
			//run query to update Person table with NULL values for verifyCode and ownerId for current user
			$query2 = "UPDATE Person SET ownerId = NULL, verifyCode = NULL WHERE uniqueId = '$UniqueId'";
			$result2 = $conn->query($query2);
			returnToHomepage();
		}
	}
//Close connection
$conn->close();
?>
