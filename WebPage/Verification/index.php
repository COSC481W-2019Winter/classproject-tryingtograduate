<!doctype html>
<!Verification code>
<html>
	<head>
		<?php
		//Variables needed to access current user in Person
		session_start();
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
<?php
	//git variables form person table
	$queryVerifciationCode = "SELECT verifyCode FROM Person WHERE emailAddress = '$UserEmail';";
	$resultVerificationCode = mysqli_query($conn, $queryVerifciationCode);
	$codeRow = $resultVerificationCode->fetch_assoc();
	$code = $codeRow['verifyCode'];
	echo $code;

	//check to see if SUBMIT button has been clicked		
	if(isset($_POST['code']))
	{
		echo $code;
	 	if($_POST['code'] == $code)
		{
			//set query and execute to update person parameters on click
			$query = "UPDATE Person SET verifyCode = NULL, ownerId = NULL WHERE emailAddress = '$UserEmail'";
			mysqli_query($conn, $query);
			
			//alert user of good verification and redirect to home
			echo '<script language="javascript">';
			echo 'alert("Verification Successful!")';
			echo '</script>';
			echo '<script language="javascript">';
			echo 'window.location.href ="../home"';
			echo '</script>';
		}
		else
		{
			//if bad code, alert and stay on page
			echo '<script language="javascript">';
			echo 'alert("Verification failed!")';
			echo '</script>';
		}
	}
?>
