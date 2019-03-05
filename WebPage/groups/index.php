<?php session_start();
	$a = "tboyd10@emich.edu";
	$_SESSION[currentUserEmail]= $a;
?>
<!doctype html>
<!Group Page>
<html>
	<head>
		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="../CSS/groupStyle.css">
    <link rel="stylesheet" type="text/css" href="../CSS/homeStyle.css">

		<script>
			//function to grab the value of the "Username:" field on the Sign-In form of homepage
			//method is called by "onload" in <body> tag
			function user(){

				var user = "Not Working"
				//loads the value into a variable called user
				//use this value in sql query: SELECT uniqueId FROM Person where emailAddress = value in user var
				user = localStorage.getItem("userId");
				//echo's value to screen with message stating who is logged in
				document.getElementById("user").innerHTML = "Logged in as:  " + user;
			}
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
	<body onload = "user();">
		<h3 id = "user" style = "text-align: left" ><span id = "user"></span></h3>
		<h1 id = "Company" style = "text-align: center" >Manage Groups</h1>
		</br>
        <div id="all">
					<form name="glist" action="" method="post">
						<input type="hidden" id="uEmail" name="uEmail">
						<select id="glist" name="glist" onchange="this.form.submit()">
							<option value="0">Select Group</option>
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


            <button class="button" id="addGroup" onclick="newGroupFunc()">Add Group</button>
            <button class="button" id="editGroup" onclick="newContactFunc()">Edit Group</button>
            <button class="button" id="exit" onclick = "window.location.href = '../dashboard'">Exit to Main</button>

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
								<label>Phone Number:</label>
								<input type="text" name="newCphone" placeholder="###-###-####">
								<label>E-mail:</label>
								<input type="text" name="newCemail" placeholder="example@email.com">
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
							</tr>

							<?php
							session_start();
								//Variables created to access the database on Wi2017_436_kbledsoe3
							  $servername = "localhost";
								$db_username = "kbledsoe3";     //Username for MySQL
								$db_password = "1784793b4a";     //Password for MySQL
								$db_name   = "Wi2017_436_kbledsoe3"; //Database name
									$selectedGroup = $_POST['glist'];
									$_SESSION['currentGroup']= $selectedGroup;
									// Create connection
									$conn = new mysqli($servername, $db_username, $db_password, $db_name);
									if(isset($_POST['glist'])){

										$sql = "SELECT Person.firstName, Person.lastName, Person.emailAddress, Person.phoneNumber FROM Person, Group_JT
											WHERE Group_JT.groupId = '$selectedGroup' AND Group_JT.contactId = Person.uniqueId;";

										$result = $conn->query($sql);
										if ($result->num_rows > 0) {
										    // output data of each row
										    while($row = $result->fetch_assoc()) {
										       echo "<tr><td>". $row["firstName"]. " ". $row["lastName"]. "</td><td>". $row["phoneNumber"]. "</td><td>". $row["emailAddress"]. "</td></tr>";

									    	}
										} else {
										    echo "<tr><td>No contacts<td></tr>";
										}
									}



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
  $servername = "localhost";
	$db_username = "kbledsoe3";     //Username for MySQL
	$db_password = "1784793b4a";     //Password for MySQL
	$db_name   = "Wi2017_436_kbledsoe3"; //Database name

	//Variables created to reference input textboxes, reference html by name
	//SignUp Variables
	$newGroupName = $_POST['newGName'];

	$UserEmail = $_SESSION['currentUserEmail'];
	//Get user ID from Session
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);
	$sql = "SELECT uniqueId FROM Person WHERE emailAddress = '$UserEmail' limit 1";
	$result = $conn->query($sql);
	$id = mysqli_fetch_object($result);
	$UserId = $id->uniqueId;


	// Create connection
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);
	// Check connection

	//Testing to see if the SignUp button has been pressed referenced by html name
	if(isset($_POST['addGtoDB']))
	{
		//Test to see if the email entered already exists in the table
		$query = mysqli_query($conn, "SELECT * FROM Groups WHERE groupName = '$newGroupName';");

		if ($query->num_rows != 0) //if username exists
		{
			echo '<script language="javascript">';
				echo 'alert("Group already Exists.")';
				echo '</script>';
		}
		else //if email does not exist
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
	// CODE FOR NEW CONTACT
	$fname = $_POST['newFname'];
	$lname = $_POST['newLname'];
	$phone = $_POST['newCphone'];
	$email = $_POST['newCemail'];
	$selectedGroup = $_SESSION['currentGroup'];


	if(isset($_POST['addCtoDB']))
	{


		//Test to see if the email entered already exists in the table
		$query2 = mysqli_query($conn, "SELECT * FROM Person WHERE firstName = '$fname' AND lastName = '$lname' AND ownerId = '$UserId';");

		if ($query2->num_rows != 0) //if username exists
		{
				echo '<script language="javascript">';
				echo 'alert("Contact already Exists.")';
				echo '</script>';
		}
		else //if email does not exist
		{
			//Inserts new record into table from sql statement
			mysqli_query($conn, "INSERT INTO Person(firstName, lastName, emailAddress, phoneNumber, ownerId)
				VALUES ('$fname','$lname', '$email', '$phone', '$UserId')");

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

	//Close connection
	$conn->close();
?>
