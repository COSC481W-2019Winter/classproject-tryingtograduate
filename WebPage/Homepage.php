<!doctype html>
<!http://db2.emich.edu/~kbledsoe3/COSC481/Homepage.php>
<html>
	<head>
		<title>Carrier Pigeon</title>
		<link rel="stylesheet" type="text/css" href="homeStyle.css">
	<script></script>
	</head>

	<body>
		<h1 id = "Company" style = "text-align: center" > Carrier Pigeon </h1>
		<table id = "tables" class = "center" CELLPADDING="30" CELLSPACING="30">
			<td id = "outter1">
				<div id = "SI">
					<h3 style="text-align: center">Sign-In:</h3>
					<form id = "Sign-In">
						<label><br>Username:</br></label>
						<input id = "username" type="text" name="username" placeholder = "Username" />
						<label><br>Password:</br></label>
						<input id = "password" type="password" name="passwordEst" placeholder = "Password"/>
					</form>
					<button class = "button button1" name = "signIn" onclick="signIn();" >Sign-In</button>
				</div>
			</td>

			<td id = "outter2">
				<div id = "SU">
					<h3 class="center" style="text-align: center">Sign-Up:</h3>
					<form id = "Sign-Up" action = "" method = "post">
						<label><br>First Name:</br></label>
						<input id = "fname" type="text" name="fname" placeholder = "First Name" />
						<label><br>Last Name:</br></label>
						<input id = "lname" type="text" name="lname" placeholder = "Last Name" />
						<label><br>Email:</br></label>
						<input id = "email" type="text" name="email" placeholder = "somename@domain.com" />
						<label><br>Code:</br></label>
						<input id = "code" type="text" class = "resizedTextbox" name="code" placeholder = "####"/>
						<button class = "getCode" onclick="emailcode.html" >Get Code</button>
						<label><br>Password:</br></label>
						<input id = "passwordNew" type="password" name="passwordNew" placeholder = "Password"/>
						<label><br>Confirm:</br></label>
						<input id = "passwordNewCfm" type="password" name="passwordNewCnf" placeholder ="Password" />
						<label><br>Phone:</br></label>
						<input id = "phone" type="text" name="phone" placeholder = "###-###-####"/>
						<input class = "button button2" type = "submit" name = "SignUp" value = "Sign-Up" >
					</form>
				</div>
			</td>

		</table>
		</br></br>
	</body>
</html>
<?php
	//Variables created to access the database on Wi2017_436_kbledsoe3
    $servername = "localhost";
	$db_username = "kbledsoe3";     //Username for MySQL
	$db_password = "1784793b4a";     //Password for MySQL
	$db_name   = "Wi2017_436_kbledsoe3"; //Database name
	
	//Variables created to reference input textboxes, reference html by name 
	//$username = $_POST['username'];
	$fName = $_POST['fname'];
	$lName = $_POST['lname'];
	$eMail = $_POST['email'];
	$passwordNew = $_POST['passwordNew'];
	$phoneNum = $_POST['phone'];
	
	$username = $password = "";
	$username_err = $password_err = "";
	
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
		echo "Connection Successful!!!!!";
		//output variables to make sure they are being stored properly
	}
	
	if(isset($_POST['SignIn'])){
		// Check if username is empty
		if(empty(trim($_POST["username"]))){
			$username_err = "Please enter username.";
		}else{
			$username = trim($_POST["username"]);
		}
    
    // Check if password is empty
		if(empty(trim($_POST["password"]))){
			$password_err = "Please enter your password.";
		}else{
			$password = trim($_POST["password"]);
		}
		
		// Validate credentials
		if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
			$sql = "SELECT id, emailAddress, password FROM Person WHERE emailAddress = '$username'";
        
			if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
				$param_username = $username;
            
            // Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
                // Store result
					mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
					if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
						mysqli_stmt_bind_result($stmt, $id, $username, $passwordHash);
						if(mysqli_stmt_fetch($stmt)){
							if(password_verify($password, $passwordHash)){
                            // Password is correct, so start a new session
								session_start();
                            
                            // Store data in session variables
								$_SESSION["loggedin"] = true;
								$_SESSION["id"] = $id;
								$_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
								header("location: welcome.php");
							}else{
                            // Display an error message if password is not valid
								$password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
	}
	
	//Testing to see if the submit button has been pressed referenced by name
	if(isset($_POST['SignUp']))	
	{
		//Test to see if the email entered already exists in the table
		$query = mysqli_query($conn, "SELECT emailAddress FROM Person WHERE emailAddress = '$eMail';");
		
		if ($query->num_rows != 0) //if eamil exists
		{
			echo '<script language="javascript">';
			echo 'alert("Email already registered.")';
			echo '</script>';
		}
		else //if email does not exist
		{
			//Inserts new record into table from sql statement
			mysqli_query($conn, "INSERT INTO Person(firstName, lastName, emailAddress, passwordHash, phoneNumber) 
				VALUES ('$fName', '$lName', '$eMail', '$passwordNew	', '$phoneNum')");
			
			//Check the status of the query
			if (mysqli_affected_rows($conn) > 0)
			{
				echo '<script language="javascript">';
				echo 'alert("You have registered successfully!!")';
				echo '</script>';
			} 
			else 
			{
				echo "user not added";
			}
		}
	}
	//Close connection
	$conn->close();
?>
