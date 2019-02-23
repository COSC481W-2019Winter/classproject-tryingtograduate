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
			//username and password not found in same row in Person table
			//display box stating the user was not found
			echo '<script language="javascript">';
			echo 'alert("Successful Connection to DB2!")';
			echo '</script>';
			//reroute the user from this php file back to back to MessageDash
			//will add more functionality during weeks of 2/22/19 - 03/07/19
			echo '<script language="javascript">';
			echo 'window.location.href ="MessageDashboard.html"' ;
			echo '</script>';
		}
		
	//Close connection
	$conn->close();
?>
