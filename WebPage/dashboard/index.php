<!doctype html>
<!MessageDashboard>
<html>
	<head>

		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="../CSS/messageStyle.css">
		<script>
			//function to grab the value of the "Username:" field on the Sign-In form of homepage
			//method is called by "onload" in <body> tag
			function user(){
				var user = "Not Working"
				//loads the value into a variable called user
				//use this value in sql query: SELECT uniqueId FROM Person where emailAddress = value in user var
				user = localStorage.getItem("userId");
				//echo's value to screen with message stating who is logged in
				document.getElementById("user").innerHTML = "Welcome:  " + user;
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
	<body onload = "user();">
		</br>
		<?php
			$username = 'kristal.bledsoe@gmail.com';
			$UserId = '16';
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
				echo "Successful Connection to DB2!";
			}
			$conn->close();
		?>

		<h1 id = "Company" style = "text-align: center" >Message Dashboard</h1>
		<h2 id = "user" style = "text-align: center" ><span id = "user"></span></h2>
		<button id = "topRight" class = "button button0" onclick = "window.location.href ='../groups/index.php'" >
		Edit Groups</button>
		</br>
		<div id = "wrapper">
			<div class="navbar">
				<div class="dropdown">
					<button class="dropbtn">Select Message </button>
					<div class="dropdown-content">
						<a href="#">Office Closed</a>
						<a href="#">Staff Meeting</a>
						<a href="#">Weather Alert</a>
					</div>
				</div>
			</div>
			<div class="navbar">
			<a onclick = "saveMessage();">Save Message</a>
			</div>
			<div class="navbar">
				<div class="dropdown">
					<button class="dropbtn">Select Group</button>
					<div class="dropdown-content">
						<a href="#">Managers</a>
						<a href="#">Contractors</a>
						<a href="#">All Staff</a>
					</div>
				</div>
			</div>
		</div>
		</br>
		<div id="saveMessage" style = "text-align: center" class="savemessage">
			<form action = "" method = "post">
				<label class = "savemessage">Message name:</label>
				<input type="text" style = "width:10%" name="newMsgName" placeholder="Message Name">
				<label>Subject:</label>
				<input type="text" style = "width:38%" name="newMsgSubject" placeholder="Message Subject">
				</br></br>
				<input id="addMsgButton" type="submit" name="addMsgToDB" value="SAVE" onclick="saveMessageFunc">
				<button id = "cancel" onclick = "saveMessageFunc">CANCEL</button>
			</form>
		</div>
		</br></br>
		<textarea id = "message" class = "center" name = "message">Type message here...</textarea>
		</br></br>
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
