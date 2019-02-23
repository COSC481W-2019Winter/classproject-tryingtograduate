<!doctype html>
<html>
	<head>
		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="groupStyle.css">
    <link rel="stylesheet" type="text/css" href="../home/homeStyle.css">

		<script>
			function newGroupFunc() {
				var x = document.getElementById("newGroup");
				if (x.style.display === "none") {
					x.style.display = "block";
				} else {
					x.style.display = "none";
				}
			}
		</script>
	</head>

	<body>

		</br></br>
		<h1 id = "Company" style = "text-align: center" >Manage Groups</h1>
		</br>
        <div id="all">
						<select id="glist">
							<option value="0">Select Group</option>
							<?php
								//Variables created to access the database on Wi2017_436_kbledsoe3
							  $servername = "localhost";
								$db_username = "kbledsoe3";     //Username for MySQL
								$db_password = "1784793b4a";     //Password for MySQL
								$db_name   = "Wi2017_436_kbledsoe3"; //Database name

								//Variables created to reference input textboxes, reference html by name
								//SignUp Variables
								$UserId = 13;

								// Create connection
								$conn = new mysqli($servername, $db_username, $db_password, $db_name);

								$sql = "SELECT groupId, groupName FROM Groups WHERE ownerId = $UserId";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
								    // output data of each row
								    while($row = $result->fetch_assoc()) {
								       echo "<option value=\"". $row["groupId"]. "\">". $row["groupName"]."</option>";

							    	}
								} else {
								    echo "<option value=\"0\">You have no groups</option>";
								}


								$conn->close();
							?>


						</select>
            <button class="button" id="addGroup" onclick="newGroupFunc()">Add Group</button>
            <button class="button" id="editGroup">Edit Group</button>
            <button class="button" id="exit" onclick = "window.location.href = '../dashboard'">Exit to Main</button>

						<div id="newGroup">
							<form class="newGroup" action = "" method = "post">
								<label>Group name:</label>
								<input type="text" name="newGName" placeholder="Group Name">
								<input class="button" id="addGbutton" type="submit" name="addGtoDB" value="ADD" onclick="newGroupFunc">
								<button id="cancel" onclick="newGroupFunc">CANCEL</button>
							</form>
						</div>

						<div id="contactlist">
							<table>
								<tr>
									<thead></thead>
									<thead></thead>
									<thead></thead>
								</tr>
							</table>
						</div>


        </div>
	</body>
</html>

<!-- CHANGE 5.0 -->
<?php
	//Variables created to access the database on Wi2017_436_kbledsoe3
  $servername = "localhost";
	$db_username = "kbledsoe3";     //Username for MySQL
	$db_password = "1784793b4a";     //Password for MySQL
	$db_name   = "Wi2017_436_kbledsoe3"; //Database name

	//Variables created to reference input textboxes, reference html by name
	//SignUp Variables
	$newGroupName = $_POST['newGName'];
  $UserId = 13;


	// Create connection
	$conn = new mysqli($servername, $db_username, $db_password, $db_name);
	// Check connection


	//Testing to see if the SignUp button has been pressed referenced by html name
	if(isset($_POST['addGtoDB']))
	{
		//Test to see if the email entered already exists in the table
		$query = mysqli_query($conn, "SELECT groupName FROM Groups WHERE groupName = '$newGroupName';");

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

	//Close connection
	$conn->close();
?>
