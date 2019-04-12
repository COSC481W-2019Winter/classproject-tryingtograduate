<!doctype html>
<!MessageDashboard>
<?php session_start();
?>
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
			//stores selected group from dropdown as a cookie to be used by PHP
			//this avoids page refresh upon selection
			function groupPickFunc(){
				var x = document.getElementById('glist').value;
				document.cookie = "selectedGroup="+x;
			}
			//PHP will need to call this method after SEND is clicked to clear the cookie
			function clearCookie(){
				document.cookie = selectedGroup+'=; Max-Age=-99999999;';
			}
		</script>
	</head>
	<body>
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
		//get ownerId of current user from Person
		/*$queryB = "SELECT ownerId FROM Person WHERE emailAddress = '$UserEmail'";
		$resultB = $conn->query($queryB);
		$idB = mysqli_fetch_object($resultB);
		$OwnerId = $idB->ownerId;*/
		echo "Logged in as:  ", $FirstNm, " ", $LastNm;
		//use $UniquiId established above to output current users template list from Message
		$result = $conn->query("SELECT messageId, templateName FROM Message WHERE ownerId = $UniqueId AND templateName IS NOT NULL");
		//use $UniqueId established above to access groups for current user from Groups table
		$result1 = $conn->query("SELECT groupId, groupName FROM Groups WHERE ownerId = $UniqueId");
	?>
		</br>
		<h1 id = "Company" style = "text-align: center" >Message Dashboard</h1>
		<h2 id = "user" style = "text-align: center" ><span id = "user"></span></h2>
		<button id = "topRight" class = "button button0" onclick = "window.location.href ='../groups/index.php'" >
		Edit Groups</button>
		</br>
		<!navigation bar starts here>
		<div id = "wrapper">
			<div class="navbar">
				<div class="dropdown">
					<!form for template dropdown starts here>
					<form name="tlist" action = "" method = "post">
						<select id="tmpList" name="tmpList" class = "dropbtn" onchange = "this.form.submit()">
							<option  type  = 'submit' value="0"class="dropdown-content" name = 'selection'>Select Message</option>
							<?php
								// output data of each row that matches query "$result" listed above
								while($row = $result->fetch_assoc()) {
								$temp_name = $row['templateName'];
								echo"<option name = 'tmpSelect' value = '$temp_name'>$temp_name</option>";
							    }
							?>
						</select>
					</form>
					<!template dropdown form ends here>
				</div>
			</div>
			<div class="navbar">
			<a onclick = "saveMessage();">Save Message</a>
			</div>
			<div class="navbar">
				<div class="dropdown">
				<!Form used to display templates in dropdown and select starts here>
				<form action="" method="post">
					<form name="glist" action="" method="post">
						<select id="glist" name="glist" class = "dropbtn" onchange = 'groupPickFunc();'>
							<option value="0"class="dropdown-content">Select Group</option>
							<?php
								// output data of each row that matches query "$result1" listed above
								while($row = $result1->fetch_assoc()) {
								$group_name = $row['groupName'];
								echo "<option value = '$group_name'>$group_name</option>";
							    }
							?>
						</select>
					</form><!Display & Select templates ends here>
				</div>
			</div></br>
			<div id="saveMessage" style = "text-align: center" class="savemessage">
			<!form to save message as template>
			<form action = "" method = "post">
				</br>
				<label class = "savemessage">Message name:</label>
				<input type="text" style = "width:20%" placeholder="Message Name" id = "tempName" name = "tempName">
				</br>
				<input id="addMsgButton" name = "addMsgButton" type="submit" value="SAVE">
				<button id = "cancel">CANCEL</button>
		</div></br>
		<label class = "savemessage">Subject:</label>
		<input type="text" placeholder="Message Subject" id = "tempSubject", name = "tempSubject" value = "<?php 
			if(isset($_POST['tmpList'])){
			$temp_select = $_POST['tmpList'];
			$query3 = "SELECT subject FROM Message WHERE templateName = '$temp_select' AND ownerId = $UniqueId";
			$result3 = $conn->query($query3);
			$tm = mysqli_fetch_object($result3);
			$subject = $tm->subject;
			echo $subject;
			}?>">
		</br></br>
		<textarea id = "message" name = "message" class = "center"><?php
			if(isset($_POST['tmpList'])){
			$temp_select = $_POST['tmpList'];
			$query4 = "SELECT content, subject FROM Message WHERE templateName = '$temp_select' AND ownerId = $UniqueId";
			$result4 = $conn->query($query4);
			$tm = mysqli_fetch_object($result4);
			$body = $tm->content;
			echo $body;
			}
		?></textarea>
		</br></br>
		<table class = "center">
		<td>
			<tr><td><input id = "send" name = "send" class = "button buttonA" type = "submit" value = "Send">
			</td></form><!end of form to save message as template>
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
	//check to see if SAVE button has been clicked		
	if(isset($_POST['addMsgButton']))
	{
		//Test to see if the template information entered already exists in the table
		$query2 = mysqli_query($conn, "SELECT * FROM Message WHERE templateName = '$tempName' AND ownerId = '$UniqueId';");
		if ($query2->num_rows != 0) //if template exists
		{
				echo '<script language="javascript">';
				echo 'alert("Template already Exists.")';
				echo '</script>';
		}
		else //if template does not exist
		{
			//Inserts new record into Message table from sql statement
			mysqli_query($conn, "INSERT INTO Message(ownerId, subject, content, templateName)
				VALUES ('$UniqueId', '$tempSubject', '$tempMsg', '$tempName')");
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
				echo 'alert("Template not saved.  Something went wrong.")';
				echo '</script>';
			}
		}
	}
	//Code activated when SEND button is clicked
	if(isset($_POST['send'])){
		
		//Get groupId based on group selection
		$selectedGroup = $_COOKIE['selectedGroup'];
		$results = mysqli_query($conn, "SELECT groupId FROM Groups WHERE groupName = '$selectedGroup'");
		if (mysqli_affected_rows($conn) > 0) //if rows are more than 0, selected group found in tables
		{
				//Get the row as an object
				$object = mysqli_fetch_object($results);
				//Extract the information you want by using the column name
				$grId = $object->groupId;
				
				//Insert message to Message Table when Send is clicked
				mysqli_query($conn, "INSERT INTO Message(ownerId, groupId, subject, content)
				VALUES ('$UniqueId','$grId', '$tempSubject', '$tempMsg')");
				
				//Select messageId from Message table for message saved when Send was clicked
				//Query will look for max message ID because the message saved will be the last in the list
				$results2 = mysqli_query($conn, "SELECT MAX(messageId) AS max FROM Message");
				if (mysqli_affected_rows($conn) > 0) //if rows are more than 0, max found in tables
				{
					//Get the associated value (in this case we asked for something specific rather than a row)
					$object2 = mysqli_fetch_assoc($results2);
					//use the nickname max we created in our SELECT statement to grab the id number and store
					$msId = $object2['max'];
					//use the stored messageId to insert a job into the Queue
					mysqli_query($conn, "INSERT INTO Queue(messageId)VALUES ('$msId')");
					//Alert the user of successful message deployment
					echo '<script language="javascript">';
					echo 'alert("Your message has been added to the queue and will be sent shortly.")';
					echo '</script>';
				}
		}else{
			//alert the user if they have not yet selected a group
			//code needs to die here so that page is not refreshed b/c user will lose their message
			echo '<script language="javascript">';
			echo 'alert("Please Select a Group")';
			echo '</script>';
		}
	}
	$conn->close();
?>
