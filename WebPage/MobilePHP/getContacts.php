<?php
$userId = filter_input(INPUT_POST, "userId");
$selectedGroupName = filter_input(INPUT_POST, "selectedGroupName");


include ('../PHP/Database.php');
// Create connection
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

$contacts = array();
$contactqry = "SELECT Person.firstName, Person.lastName FROM Person, Group_JT
    WHERE Group_JT.groupId = (SELECT groupId FROM Groups WHERE groupName = '$selectedGroupName' AND ownerId = '$userId') AND Group_JT.contactId = Person.uniqueId";

$resultcontacts = $conn->prepare($contactqry);
$resultcontacts->execute();
$resultcontacts->bind_result($firstName, $lastName);

while ($resultcontacts->fetch()){
  $temp = [
    'firstName'=>$firstName,
    'lastName'=>$lastName
  ];


  array_push($contacts, $temp);
}

echo json_encode($contacts);

$conn->close();

?>
