<!doctype html>
<!MessageDashboard>
<html>
	<head>

		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="../CSS/messageStyle.css">
		<script>
			//function to grab the value of the "Username:" field on the Sign-In form of homepage
			//method is called by "onload" in <body> tag---not currently being called (using $_SESSION)
			function user(){

				var user = "Not Working"
				//loads the value into a variable called user
				//use this value in sql query: SELECT uniqueId FROM Person where emailAddress = value in user var
				user = localStorage.getItem("userId");
				//echo's value to screen with message stating who is logged in
				document.getElementById("user").innerHTML = "Logged in as:  " + user;
			}
			function saveMessage() {
				var header = document.getElementById("saveMessage");
				if (header.style.display === "none") {
					header.style.display = "block";
				} else {
					header.style.display = "none";
				}
			}
		</script>
	</head>
	<body>
		</br>
		<h1 id = "Company" style = "text-align: center" >Message Dashboard</h1>
		<h2 id = "user" style = "text-align: center" ><span id = "user"></span></h2>
		<button id = "topRight" class = "button button0" onclick = "window.location.href ='../groups/index.php'" >
		Edit Groups</button>
		</br>
		<div id = "wrapper">
			<div class="navbar">
				<div class="dropdown">
					<form name="glist" action="" method="post">
						<select id="tmpList" name="tmpList" class = "dropbtn" >
							<option  value="0"class="dropdown-content">Select Message</option>
							<?php
								session_start();
								//Variables created to access the database on Wi2017_436_kbledsoe3
							  $servername = "localhost";
								$db_username = "kbledsoe3";     //Username for MySQL
								$db_password = "1784793b4a";     //Password for MySQL
								$db_name   = "Wi2017_436_kbledsoe3"; //Database name

								//Variables created to reference input textboxes, reference html by name
								//SignUp Variables
								$UserEmail = $_SESSION['currentUserEmail'];


								// Create connection
								$conn = new mysqli($servername, $db_username, $db_password, $db_name);
								$sql = "SELECT uniqueId FROM Person WHERE emailAddress = '$UserEmail' limit 1";
								$result = $conn->query($sql);
								$id = mysqli_fetch_object($result);
								$UserId = $id->uniqueId;


								$sql = "SELECT messageId, templateName FROM Message WHERE ownerId = $UserId";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    // output data of each row
								    while($row = $result->fetch_assoc()) {
								       echo "<option value=\"". $row["messageId"]. "\">". $row["templateName"]."</option>";
							    	}
								} else {
								    echo "<option value=\"4\">You have no templates</option>";
								}
								$conn->close();
							?>
						</select>
					</form>
				</div>
			</div>
			<div class="navbar">
			<a onclick = "saveMessage();">Save Message</a>
			</div>
			<div class="navbar">
				<div class="dropdown">

					<form name="glist" action="" method="post">
						<select id="glist" name="glist" class = "dropbtn">
							<option value="0"class="dropdown-content">Select Group</option>
							<?php
								session_start();
								//Variables created to access the database on Wi2017_436_kbledsoe3
							  $servername = "localhost";
								$db_username = "kbledsoe3";     //Username for MySQL
								$db_password = "1784793b4a";     //Password for MySQL
								$db_name   = "Wi2017_436_kbledsoe3"; //Database name

								//Variables created to reference input textboxes, reference html by name
								//SignUp Variables
								$UserEmail = $_SESSION['currentUserEmail'];


								// Create connection
								$conn = new mysqli($servername, $db_username, $db_password, $db_name);
								$sql = "SELECT uniqueId FROM Person WHERE emailAddress = '$UserEmail' limit 1";
								$result = $conn->query($sql);
								$id = mysqli_fetch_object($result);
								$UserId = $id->uniqueId;


								$sql = "SELECT groupId, groupName FROM Groups WHERE ownerId = $UserId";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    // output data of each row
								    while($row = $result->fetch_assoc()) {
								       echo "<option value=\"". $row["groupId"]. "\">". $row["groupName"]."</option>";

							    	}
								} else {
								    echo "<option value=\"4\">You have no groups</option>";
								}


								$conn->close();
							?>
						</select>
					</form>

			</div>
		</div>
		</br>
		<div id="saveMessage" style = "text-align: center" class="savemessage">
			<form action = "" method = "post">
				<label class = "savemessage">Message name:</label>
				<input type="text" style = "width:10%" placeholder="Message Name" id = "tempName" name = "tempName">
				<label>Subject:</label>
				<input type="text" style = "width:38%" placeholder="Message Subject" id = "tempSubject" name = "tempSubject">
				</br></br>
				<input id="addMsgButton" name = "addMsgButton" type="submit" value="SAVE">
				<button id = "cancel">CANCEL</button>

		</div>
		</br></br>
		<textarea id = "message" class = "center" name = "message">Type message here...</textarea>
		</br></br>
		</form>
		<table class = "center">
		<td>

			<tr><td><button class = "button buttonA" onclick = "window.location.href ='../dashboard/index.php'" >
			Send</button></td>
			<td><button class = "button buttonB" onclick = "window.location.href ='../home/index.html'" >
			Sign-Out</button></td>
			<td><button class = "button buttonC" onclick = "window.location.href = '../dashboard/index.php'">
			Cancel</button></td>
		</td>
		</table>
	</body>
</html>
<?php
	session_start();
	//Variables needed to save the message
	$tempName = $_POST['tempName'];
	$tempSubject = $_POST['tempSubject'];
	$tempMsg = $_POST['message'];
	$groupId = '10';
	$UserEmail = $_SESSION['currentUserEmail'];

	//Variables created to access the database on Wi2017_436_kbledsoe3
	$servername = "localhost";
	$db_username = "kbledsoe3";     //Username for MySQL
	$db_password = "1784793b4a";     //Password for MySQL
	$db_name   = "Wi2017_436_kbledsoe3"; //Database name

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
		$queryA = "SELECT uniqueId FROM Person WHERE emailAddress = '$UserEmail'";
		$resultA = $conn->query($queryA);
		$idA = mysqli_fetch_object($resultA);
		$UniqueId = $idA->uniqueId;

		$queryB = "SELECT ownerId FROM Person WHERE emailAddress = '$UserEmail'";
		$resultB = $conn->query($queryB);
		$idB = mysqli_fetch_object($resultB);
		$OwnerId = $idB->ownerId;

		$queryC = "SELECT firstName FROM Person WHERE emailAddress = '$UserEmail'";
		$resultC = $conn->query($queryC);
		$idC = mysqli_fetch_object($resultC);
		$FirstNm = $idC->firstName;

		$queryD = "SELECT lastName FROM Person WHERE emailAddress = '$UserEmail'";
		$resultD = $conn->query($queryD);
		$idD = mysqli_fetch_object($resultD);
		$LastNm = $idD->lastName;

		echo "Logged in as:  ", $FirstNm, " ", $LastNm;
	}
	//check to see if SAVE button has been clicked
	if(isset($_POST['addMsgButton']))
	{
		//Test to see if the template information entered already exists in the table
		$query2 = mysqli_query($conn, "SELECT * FROM Message WHERE templateName = '$tempName' AND subject = '$tempSubject' AND ownerId = '$OwnerId';");

		if ($query2->num_rows != 0) //if username exists
		{
				echo '<script language="javascript">';
				echo 'alert("Template already Exists.")';
				echo '</script>';
		}
		else //if template does not exist
		{
			//Inserts new record into table from sql statement
			mysqli_query($conn, "INSERT INTO Message(ownerId, groupId, subject, content, templateName)
				VALUES ('$UniqueId','$groupId', '$tempSubject', '$tempMsg', '$tempName')");

			//Check the status of the query
			if (mysqli_affected_rows($conn) > 0)
			{
				echo '<script language="javascript">';
				echo 'alert("Template added successfully!!")';
				echo '</script>';
				// Re-route back to dashboard
				echo '<script language="javascript">';
				echo 'window.location.href ="../dashboard/"' ;
				echo '</script>';
			}
			else
			{
				echo '<script language="javascript">';
				echo 'alert("Template not saved.  More work to do.")';
				echo '</script>';
			}
		}
	}
	$conn->close();
?>
