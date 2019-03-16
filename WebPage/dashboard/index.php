<!doctype html>
<!MessageDashboard>
<html>
	<head>
		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="../CSS/messageStyle.css">
		<script>
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
	<body onload >
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
		//get ownerId of current user from Person
		$queryB = "SELECT ownerId FROM Person WHERE emailAddress = '$UserEmail'";
		$resultB = $conn->query($queryB);
		$idB = mysqli_fetch_object($resultB);
		$OwnerId = $idB->ownerId;
		echo "Logged in as:  ", $FirstNm, " ", $LastNm;
	?>
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
								//use $UniquiId established above to output current users template list from Message
								$sql = "SELECT messageId, templateName FROM Message WHERE ownerId = $UniqueId";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    // output data of each row
								    while($row = $result->fetch_assoc()) {
								       echo "<option value=\"". $row["messageId"]. "\">". $row["templateName"]."</option>";
							    	}
								} else {
								    echo "<option value=\"4\">You have no templates</option>";
								}
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
								//use $UniqueId established above to access groups for current user from Groups table
								$sql = "SELECT groupId, groupName FROM Groups WHERE ownerId = $UniqueId";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    // output data of each row
								    while($row = $result->fetch_assoc()) {
								       echo "<option value=\"". $row["groupId"]. "\">". $row["groupName"]."</option>";
							    	}
								} else {
								    echo "<option value=\"4\">You have no groups</option>";
								}
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
	
	//Variables needed to save the message
	$tempName = $_POST['tempName'];
	$tempSubject = $_POST['tempSubject'];
	$tempMsg = $_POST['message'];
	$groupId = '10';
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
			//Inserts new record into Message table from sql statement
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
