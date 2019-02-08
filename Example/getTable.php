<!--
Kristal Bledsoe
http://db2.emich.edu/~kbledsoe3/041117/gettable.php
COSC 436
Assignment 04/11/2017 PHP/MYSQL (SERVER-SIDE)
WINTER 2017
-->
<!DOCTYPE html>
<html>
<head>
	<style>
	table {
		width: 100%;
		border-collapse: collapse;
	}

	table, td, th {
		border: 1px solid black;
		padding: 5px;
	}

	th {text-align: left;}
	</style>
</head>
	<body>
		<?php
		//Variables created to access the database on Wi2017_436_kbledsoe3
		$servername = "localhost";
		$db_username = "kbledsoe3";     
		$db_password = "1784793b4a";   
		$db_name   = "Wi2017_436_kbledsoe3"; 

		//Creates a sql query based on the choice selected from dropdown
		$q = intval($_GET['q']);
			if($q == 1)//In this case I only have one table as an option
			{	//if the user selects the first (only) table - create query
				$q = "SELECT * FROM CauseOfDeath";
			}

		// Create connection
			$conn = new mysqli($servername, $db_username, $db_password, $db_name);

		if (!$conn) {
			die('Could not connect: ' . mysqli_error($conn));
		}
		else
		{
			echo "successful connection to database";
		}
		//Test to see if connection was made and output confirmation
		$result = mysqli_query($conn,$q);
		if ($result == TRUE)
					{
						echo "    and query rendered successfully";
					}
					else
					{
						echo "   but query did not render";
					}

		//Create title row for database table
		echo "<table>
				<tr>
					<th>age</th>
					<th>leadingCause</th>
					<th>secondary</th>
					<th>tertiary</th>
					<th>quaternary</th>
				</tr>";
				
		//Walk through database table and add database records to html table		
		while($row = mysqli_fetch_array($result)) {
			echo "<tr>";
			echo "<td>" . $row['age'] . "</td>";
			echo "<td>" . $row['leadingCause'] . "</td>";
			echo "<td>" . $row['secondary'] . "</td>";
			echo "<td>" . $row['tertiary'] . "</td>";
			echo "<td>" . $row['quaternary'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";

		//Close connection
		mysqli_close($conn);
		?>
	</body>
</html>
