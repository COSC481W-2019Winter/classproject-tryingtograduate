<!doctype html>
<!Verification code>
<html>
	<head>
		<?php
		//Variables needed to access current user in Person
		$UserEmail = $_SESSION['currentUserEmail'];
		include ('../PHP/Database.php');
		// Create connection
		$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);
		//get first name	
		$queryC = "SELECT firstName FROM Person WHERE emailAddress = '$UserEmail' AND ownerId IS NULL";
		$resultC = $conn->query($queryC);
		$idC = mysqli_fetch_object($resultC);
		$FirstNm = $idC->firstName;	
		//get last name
		$queryD = "SELECT lastName FROM Person WHERE emailAddress = '$UserEmail' AND ownerId IS NULL";
		$resultD = $conn->query($queryD);
		$idD = mysqli_fetch_object($resultD);
		$LastNm = $idD->lastName;	
		//get uniqueId of current user from Person
		$queryA = "SELECT uniqueId FROM Person WHERE emailAddress = '$UserEmail' AND ownerId IS NULL";
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
			</br><input id = "subCode" class = "button2" type = "submit" name = "subCode" value = "SUBMIT">
			</form>
		</div>
	</body>
</html>
<?php
//Variables needed to save the code entered
	$code = $_POST['code'];

	//check to see if SUBMIT button has been clicked		
	if(isset($_POST['subCode']))
	{
	 	
	}
?>
