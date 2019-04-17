<!doctype html>
<!Verification code>
<html>
	<head>
		<?php
		session_start();
		//Variables needed to access current user in Person
		$UserEmail = $_SESSION['currentUserEmail'];
		include ('../PHP/Database.php');
		// Create connection
		$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
		//get first name	
		$queryC = "SELECT firstName FROM Person WHERE emailAddress = '$UserEmail'";
		$resultC = $conn->query($queryC);
		$idC = mysqli_fetch_object($resultC);
		$FirstNm = $idC->firstName;	
		//get last name
		$queryD = "SELECT lastName FROM Person WHERE emailAddress = '$UserEmail'";
		$resultD = $conn->query($queryD);
		$idD = mysqli_fetch_object($resultD);
		$LastNm = $idD->lastName;	
		//get uniqueId of current user from Person
		$queryA = "SELECT uniqueId FROM Person WHERE emailAddress = '$UserEmail'";
		$resultA = $conn->query($queryA);
		$idA = mysqli_fetch_object($resultA);
		$UniqueId = $idA->uniqueId;
		echo "Hello: ", $FirstNm, " ", $LastNm;
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
			<input id = "code" name = "code" type="textbox" name="code" placeholder = "######"/>
			</br><input id = "subCode" class = "button2" type = "submit" name = "subCode" onclick="removeday()" value = "SUBMIT">
			</form>
		</div>
	</body>
</html>
<!***************** None of this PHP code has been tested but it will get us started on PART C ****************>
<?php
//Variables needed to save the code entered
/*
	$code = $_POST['code'];
	//check to see if SUBMIT button has been clicked		
	if(isset($_POST['subCode']))
	{
		//query to check if code entered matches the verifyCode in same row as uniqueId of current user
		$query1 = "SELECT uniqueId from Person WHERE verifyCode = '$code' AND emailAddress = '$userEmail'";
		$result1 = $conn->query($query1);
		//if query results in a row found
		if ($result1->num_rows != 0)
		{
			//run query to update Person table with NULL values for verifyCode and ownerId for current user
			$query2 = "UPDATE Person SET ownerId = NULL, verifyCode = NULL WHERE uniqueId = '$UniqueId'";
			$result2 = $conn->query($query2);
		}
	}*/
//Close connection
$conn->close();
?>
