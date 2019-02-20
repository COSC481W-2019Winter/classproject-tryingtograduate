<?php
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
			//let user know connection is successful for demo purposes
			echo '<script language="javascript">';
			echo 'alert("Successful Connection to DB2!")';
			echo '</script>';
			//reroute the user from this php file back to back to MessageDash
			//will add more functionality during weeks of 2/22/19 - 03/07/19
			echo '<script language="javascript">';
			echo 'window.location.href ="MessageDashboard.html"' ;
			echo '</script>';
		}

  //Code that needs to be added during weeks of 02/22/19 - 03/07/19

  //Need to create variable for message user typed in <textarea>
  //Implement the use of innerHTML on MessageDashboard then pass variable to PHP
  /*function evaluateInput(){
				var searchArea = document.getElementById("display").value;
				var global = document.getElementById("global").innerHTML;
				return input;
			}*/

  //Need to create code in html MessageDashboard for pop up to add name and subject line for message

  //Need to create PHP for onchange event for dropdown (group and/or message)

  //Need to create PHP for "cancel button"

  //Need to create a seperate PHP for send/submit   

	//Close connection
	$conn->close();
?>
