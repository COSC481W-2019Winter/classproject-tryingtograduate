<?php
	//SignIn variables passed from html "name" field of input tag
	$user = filter_input(INPUT_POST, 'user');
	
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
			//Sets a variable ($query) equal to the mysql query we want to run
			echo '<script language="javascript">';
			echo 'alert('$user')';
			echo '</script>';
		}
		
	//Close connection
	$conn->close();
?>