<?php
include ('../PHP/Database.php');
// Create connection
$conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

  $tempSubject = filter_input(INPUT_POST, "subject");
  $tempMsg = filter_input(INPUT_POST, "body");
  $selectedGroup = filter_input(INPUT_POST, "selectedGroupName");
  $UniqueId = filter_input(INPUT_POST, "userId");
  //Get groupId based on group selection

  $results = mysqli_query($conn, "SELECT groupId FROM Groups WHERE groupName = '$selectedGroup' AND ownerId = '$UniqueId'");
  if (mysqli_affected_rows($conn) > 0) //if rows are more than 0, selected group found in tables
  {
      //Get the row as an object
      $object = mysqli_fetch_object($results);
      //Extract the information you want by using the column name
      $grId = $object->groupId;

      //Insert message to Message Table when Send is clicked
      mysqli_query($conn, "INSERT INTO Message(ownerId, groupId, subject, content)
      VALUES ('$UniqueId','$grId', '$tempSubject', '$tempMsg')");

      //Select messageId from Message table for message saved when Send was clicked
      //Query will look for max message ID because the message saved will be the last in the list
      $results2 = mysqli_query($conn, "SELECT MAX(messageId) AS max FROM Message WHERE ownerId = '$UniqueId'");
      if (mysqli_affected_rows($conn) > 0) //if rows are more than 0, max found in tables
      {
        //Get the associated value (in this case we asked for something specific rather than a row)
        $object2 = mysqli_fetch_assoc($results2);
        //use the nickname max we created in our SELECT statement to grab the id number and store
        $msId = $object2['max'];
        //use the stored messageId to insert a job into the Queue
        mysqli_query($conn, "INSERT INTO Queue(messageId)VALUES ('$msId')");
        //Alert the user of successful message deployment
        echo 'Your message has been added to the queue and will be sent shortly.';
      }
  }else{
    //alert the user if they have not yet selected a group
    //code needs to die here so that page is not refreshed b/c user will lose their message
    echo 'Could not send.';

  }

$conn->close();
?>
