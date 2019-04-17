<?php
$userId = filter_input(INPUT_POST, "userId");

include ('../PHP/Database.php');
// Create connection
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

$groups = array();
$groupqry= "SELECT groupName FROM Groups WHERE ownerId = $userId";

$resultGroups = $conn->prepare($groupqry);
$resultGroups->execute();
$resultGroups->bind_result($groupName);

while ($stmt->fetch()){
  $temp = ['groupName'=>$groupName];

  array_push($groups, $temp);
}

echo json_encode($groups);



?>
