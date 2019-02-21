<?php
include('Database.php');
include('Contact.php');

const MESSAGE =
  "SELECT
        Queue.messageId AS messageId,
        firstName,
        lastName,
        emailAddress,
        phoneNumber,
        carrierId,
        groupId,
        subject,
        content
      FROM
      (
        SELECT
            min(taskNum) AS taskNum,
            messageId
          FROM
            Queue
      ) AS Queue
      INNER JOIN
        Message
      ON
        Queue.messageId = Message.messageId
      INNER JOIN
      (
        SELECT
            uniqueId,
            firstName,
            lastName,
            emailAddress,
            phoneNumber,
            carrierId
          FROM
            Person
        ) AS Owner
      ON
        Message.ownerId = Owner.uniqueId
    ;";

class Message
{
  var $id;
  var $firstName;
  var $lastName;
  var $emailAddress;
  var $phoneNumber;
  var $carrierEmail;
  var $group;
  var $subject;
  var $content;

  function clear()
  {
    $this->id = null;
    $this->firstName = null;
    $this->lastName = null;
    $this->emailAddress = null;
    $this->phoneNumber = null;
    $this->carrierEmail = null;
    $this->group = null;
    $this->subject = null;
    $this->content = null;
  }

  function __construct()
  {
    $this->clear();
  }

  function getNextMessage()
  {
    $this->clear();

    $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    if(!$conn)
    {
      die('Unable to connect: ' . mysql_error($conn));
    }
    $messageResult = mysqli_query($conn, MESSAGE);
    $rawMessage = mysqli_fetch_array($messageResult);

    $this->id = $rawMessage['messageId'];
    $this->firstName = $rawMessage['firstName'];
    $this->lastName = $rawMessage['lastName'];
    $this->emailAddress = $rawMessage['emailAddress'];
    $this->phoneNumber = $rawMessage['phoneNumber'];
    $carrierId = $rawMessage['carrierId'];
    $groupId = $rawMessage['groupId'];
    $this->subject = $rawMessage['subject'];
    $this->content = $rawMessage['content'];

    if($carrierId != null)
    {
      $carrierQuery =
      "SELECT
          emailAddress
        FROM
          Carrier
        WHERE
          carrierId = '$carrierId'
      ;";
      
      $carrierResult = mysqli_query($conn, $carrierQuery);
      $rawCarrier = mysqli_fetch_array($carrierResult);
      $this->carrierEmail = $rawCarrier['emailAddress'];
    }

    if($groupId == null)
    {
      die('No group assigned to message');
    }
    else
    {
      $groupQuery =
      "SELECT
          emailAddress,
          phoneNumber
        from
        (
          select
              contactId
            from
              Group_JT
            where
              groupId = '$groupId'
        ) as ContactId
        left join
        (
          select
              uniqueId,
              emailAddress,
              phoneNumber
            from
              Person
        ) as Contact
        on
          contactId = uniqueId
      ;";

      $this->group = array();
      $groupResult = mysqli_query($conn, $groupQuery);
      while($members = mysqli_fetch_array($groupResult))
      {
        array_push($this->group, new Contact($members['emailAddress'], $members['phoneNumber']));
      }
    }
  }
}
?>