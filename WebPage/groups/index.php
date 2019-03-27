<?php session_start();
?>
<!doctype html>
<!Group Page>
<html>
	<head>
		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="../CSS/groupStyle.css">
    <link rel="stylesheet" type="text/css" href="../CSS/homeStyle.css">

		<script>
			function newGroupFunc() {
				var x = document.getElementById("newGroup");
				if (x.style.display === "none") {
					x.style.display = "block";
				} else {
					x.style.display = "none";
				}
			}
			function newContactFunc() {
				var x = document.getElementById("newContact");
				if (x.style.display === "none") {
					x.style.display = "block";
				} else {
					x.style.display = "none";
				}
			}
			function groupPickFunc(){
				var x = document.getElementById('glist').value;
				var group = document.getElementById('groupPicked');
				group.value = x;
				alert(x);
			}
		</script>
	</head>
	<body>
	<?php
		//Variables needed to access current user in Person
		$UserEmail = $_SESSION['currentUserEmail'];
		//Variables created to access the database on Wi2017_436_kbledsoe3
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
		echo "Logged in as:  ", $FirstNm, " ", $LastNm;
		// Set Session Variable
		if(isset($_POST['glist'])){
			$_SESSION['currentGroup']= $_POST['glist'];
		}
		$conn->close();
	?>
		<h3 id = "user" style = "text-align: left" ><span id = "user"></span></h3>
		<h1 id = "Company" style = "text-align: center" >Manage Groups</h1>
		<button style="position: fixed; top: 0; right: 0; width: 200px;" class="button button0" onclick="window.location.href ='../dashboard/index.php'" >
		Exit to Main</button>
		</br>
        <div id="all">
					<form name="glist" action="" method="post">
						<select id="glist" name="glist" onchange="this.form.submit()" >
							<option value="0">Select Group</option>
							<?php
								session_start();
								$UserEmail = $_SESSION['currentUserEmail'];
								$groupSelected = $_SESSION['currentGroup'];

								// Create connection
								include ('../PHP/Database.php');
								// Create connection
								$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

								$sql = "SELECT uniqueId FROM Person WHERE emailAddress = '$UserEmail' limit 1";
								$result = $conn->query($sql);
								$id = mysqli_fetch_object($result);
								$UserId = $id->uniqueId;


								$sql = "SELECT groupId, groupName FROM Groups WHERE ownerId = $UserId";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    // output data of each row
								    while($row = $result->fetch_assoc()) {
											if($groupSelected == $row["groupId"]){
												echo "<option value=\"". $row["groupId"]. "\" selected=\"selected\">". $row["groupName"]."</option>";
											}else{
												echo "<option value=\"". $row["groupId"]. "\">". $row["groupName"]."</option>";
											}

							    	}
								} else {
								    echo "<option value=\"4\">You have no groups</option>";
								}


								$conn->close();
							?>
						</select>
					</form>


            <button class="button" id="addGroup" onclick="newGroupFunc()">Add Group</button>
            <button class="button" id="editGroup" onclick="newContactFunc()">Add Contact</button>
						<form style="float: right; width: 20%;" action="" method="post">
            	<input style="width: 100%;"type=submit class="button" id="exit" name="delGroup" value="Delete Group">
						</form>

						<div id="newGroup">
							<form class="newGroup" action = "" method = "post">
								<label>Group name:</label>
								<input type="text" name="newGName" placeholder="Group Name">
								<input type="hidden" id="uEmail" name="uEmail">
								<input class="button" id="addGbutton" type="submit" name="addGtoDB" value="ADD" onclick="newGroupFunc">
								<button id="cancel" onclick="newGroupFunc">CANCEL</button>
							</form>
						</div>

						<div id="newContact">
							<form class="newContact" action = "" method = "post">
								<label>First name:</label>
								<input type="text" name="newFname" placeholder="First Name">
								<label>Last name:</label>
								<input type="text" name="newLname" placeholder="Last Name">
								<label>E-mail:</label>
								<input type="text" name="newCemail" placeholder="example@email.com">
								<label>Phone Number:</label>
								<input type="text" name="newCphone" placeholder="###-###-####">
								<select id="carrier" name="carrier">
									<option value="0">Select Carrier</option>
									<option value="1">Verizon</option>
									<option value="2">Sprint</option>
									<option value="3">T-mobile</option>
									<option value="4">AT&T</option>
									<option value="5">Cricket</option>
								</select>
								<input type="hidden" id="groupPicked" name="groupPicked">
								<input type="hidden" id="uEmail" name="uEmail">
								<input class="button" id="addCbutton" type="submit" name="addCtoDB" value="ADD" onclick= "newContactFunc">
								<button id="cancel" onclick="newContactFunc">CANCEL</button>
							</form>
						</div>

						<table id="contactList">
							<tr>
								<th>Name</th>
								<th>Phone Number</th>
								<th>E-mail Address</th>
								<th>Delete</th>
							</tr>

							<?php
							session_start();
								//Variables created to access the database on Wi2017_436_kbledsoe3
								include ('../PHP/Database.php');
								// Create connection
								$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

								// ON Group list dropdown change run this function
								//if(isset($_POST['glist'])){
									$selectedGroup = $_SESSION['currentGroup'];

									$sql = "SELECT Person.firstName, Person.lastName, Person.emailAddress, Person.phoneNumber, Person.uniqueId FROM Person, Group_JT
										WHERE Group_JT.groupId = '$selectedGroup' AND Group_JT.contactId = Person.uniqueId;";

									$result = $conn->query($sql);
									if ($result->num_rows > 0) {
									    // output data of each row
									    while($row = $result->fetch_assoc()) {
									       echo "<tr><td>". $row["firstName"]. " ". $row["lastName"]. "</td><td>". $row["phoneNumber"]. "</td><td>". $row["emailAddress"]. "</td>";
												 // DELETE BUTTONS WITH VALUES AND STYLING
												 echo "<td><form name=\"delContact\" action=\"\" method=\"post\">
												 				<input type=\"hidden\" id=\"delID\" name=\"delID\" value=". $row["uniqueId"]. ">
												 				<input class=\"button\" id=\"deleteContact\" type=\"submit\" name=\"deleteContact\" value=\"DELETE\"
												 				style=\"width: 55%; box-shadow: 0; padding: 0; margin: 0;\"></form></td>";

								    	}
									} else {
									    echo "<tr><td>No contacts<td></tr>";
									}
								//}



								$conn->close();
							?>

						</table>

        </div>

	</body>

</html>

<!-- CHANGE 5.0 -->
<?php
	session_start();
	//Variables created to access the database on Wi2017_436_kbledsoe3
	include ('../PHP/Database.php');
	// Create connection
	$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);


	//SignUp Variables
	$newGroupName = $_POST['newGName'];
	$UserEmail = $_SESSION['currentUserEmail'];

	//Get user ID from Session
	$sql = "SELECT uniqueId FROM Person WHERE emailAddress = '$UserEmail' limit 1";
	$result = $conn->query($sql);
	$id = mysqli_fetch_object($result);
	$UserId = $id->uniqueId;

	//-------------------------
	// CODE FOR NEW GROUP
	//-------------------------
	if(isset($_POST['addGtoDB']))
	{
		//Test to see if the groupname entered already exists in the table
		$query = mysqli_query($conn, "SELECT * FROM Groups WHERE groupName = '$newGroupName' AND ownerId = '$UserId';");

		if ($query->num_rows != 0)
		{
				echo '<script language="javascript">';
				echo 'alert("Group already Exists.")';
				echo '</script>';
		}
		else
		{
			//Inserts new record into table from sql statement
			mysqli_query($conn, "INSERT INTO Groups(groupName, ownerId) VALUES ('$newGroupName','$UserId')");

			//Check the status of the query
			if (mysqli_affected_rows($conn) > 0)
			{
				echo '<script language="javascript">';
				echo 'alert("Added successfully!!")';
				echo '</script>';
				// Re-route
				echo '<script language="javascript">';
				echo 'window.location.href ="../groups/"' ;
				echo '</script>';
			}
			else
			{
				echo "Group not added";
			}
		}
	}

	//-------------------------
	// CODE FOR NEW CONTACT
	//-------------------------
	$fname = $_POST['newFname'];
	$lname = $_POST['newLname'];
	$phone = $_POST['newCphone'];
	$email = $_POST['newCemail'];
	$carrier = $_POST['carrier'];


	if(isset($_POST['addCtoDB']))
	{
		$selectedGroup=$_SESSION['currentGroup'];
		//Test to see if the email entered already exists in the table
		$query2 = mysqli_query($conn, "SELECT * FROM Person WHERE firstName = '$fname' AND lastName = '$lname' AND emailAddress = '$email' AND ownerId = '$UserId';");

		if ($query2->num_rows != 0) //if username exists
		{
				echo '<script language="javascript">';
				echo 'alert("Contact already Exists.")';
				echo '</script>';
		}
		else //if email does not exist
		{
			//Inserts new record into table from sql statement
			mysqli_query($conn, "INSERT INTO Person(firstName, lastName, emailAddress, phoneNumber, ownerId, carrierID)
				VALUES ('$fname','$lname','$email','$phone','$UserId', '$carrier')");

			$query3 = mysqli_query($conn, "SELECT uniqueId FROM Person
				WHERE firstName = '$fname' AND lastName = '$lname' AND ownerId = '$UserId';");

			$contactId = mysqli_fetch_array($query3);

			mysqli_query($conn, "INSERT INTO Group_JT(contactId, groupOwnerId, groupId)
				VALUES ('$contactId[0]','$UserId', '$selectedGroup')");


			//Check the status of the query
			if (mysqli_affected_rows($conn) > 0)
			{
				echo '<script language="javascript">';
				echo 'alert("Added successfully!!")';
				echo '</script>';
				// Re-route
				echo '<script language="javascript">';
				echo 'window.location.href ="../groups/"' ;
				echo '</script>';
			}
			else
			{
				echo "User not added";
			}
		}
	}

	//-------------------------
	// CODE FOR DELETE CONTACT
	//-------------------------
	$deleteID = $_POST['delID'];


	if(isset($_POST['deleteContact']))
	{
		$selectedGroup=$_SESSION['currentGroup'];
		//Deletes slelected  record into table from sql statement
		mysqli_query($conn, "DELETE FROM Group_JT WHERE groupId = '$selectedGroup' AND contactId = '$deleteID';");

		//Check the status of the query
		if (mysqli_affected_rows($conn) > 0)
		{
			echo '<script language="javascript">';
			echo 'alert("Deleted successfully!!")';
			echo '</script>';
			// Re-route
			echo '<script language="javascript">';
			echo 'window.location.href ="../groups/"' ;
			echo '</script>';
		}
		else
		{
			echo "User not Deleted";
		}
	}

	//-------------------------
	// CODE FOR DELETE GROUP
	//-------------------------
	if(isset($_POST['delGroup'])){
		$selectedGroup=$_SESSION['currentGroup'];

		//Deletes all records from group
		mysqli_query($conn, "DELETE FROM Group_JT WHERE groupId = '$selectedGroup';");
		// deleetes group
		mysqli_query($conn, "DELETE FROM Groups WHERE groupId = '$selectedGroup';");

		//Check the status of the query
		if (mysqli_affected_rows($conn) > 0)
		{
			echo '<script language="javascript">';
			echo 'alert("Deleted successfully!!")';
			echo '</script>';
			// Re-route
			echo '<script language="javascript">';
			echo 'window.location.href ="../groups/"' ;
			echo '</script>';
		}
		else
		{
			echo "Group not Deleted";
		}
	}
	//Close connection
	$conn->close();
?>
