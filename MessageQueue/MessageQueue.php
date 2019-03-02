<?php
  include('Database.php');
  include('QueueConfig.php');
  include('Message.php');
  include('Contact.php');

  $allowExit = true;
  $forceExit = false;

  declare(ticks = 1);

  register_tick_function('checkExit');

  pcntl_signal(SIGTERM, "signalHandler");
  pcntl_signal(SIGHUP, "signalHandler");

  function signalHandler($signal)
  {
    global $allowExit, $forceExit;
    
    if($allowExit)
    {
      exit;
    }
    else
    {
      $forceExit = true;
    } 
  }

  function checkExit()
  {
    global $allow_exit, $force_exit;

    if ($force_exit && $allow_exit)
    {
      exit;
    }
  }

  function hasMessage()
  {
    $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    if(!$conn)
    {
      die('Unable to connect: ' . mysql_error($conn));
    }

    $result = false;

    $checkQuery =
    "SELECT
        count(*)
      FROM
        Queue
    ;";

    $checkResult = mysqli_query($conn, $checkQuery);
    $rawResult = mysqli_fetch_array($checkResult);
    $count = $rawResult[0];
    if($count > 0)
    {
      $result = true;
    }
    //echo $count . " message(s) in queue.\n\n";
    return $result;
  }

  function getNextMessage()
  {
    $result = null;

    $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    if(!$conn)
    {
      die('Unable to connect: ' . mysql_error($conn));
    }

    $result = new Message();

    $messageQuery =
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

    $messageResult = mysqli_query($conn, $messageQuery);
    $rawMessage = mysqli_fetch_array($messageResult);

    $result->id = $rawMessage['messageId'];
    $result->firstName = $rawMessage['firstName'];
    $result->lastName = $rawMessage['lastName'];
    $result->emailAddress = $rawMessage['emailAddress'];
    $result->phoneNumber = $rawMessage['phoneNumber'];
    $carrierId = $rawMessage['carrierId'];
    $groupId = $rawMessage['groupId'];
    $result->subject = $rawMessage['subject'];
    $result->content = $rawMessage['content'];

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
      $result->carrierEmail = $rawCarrier['emailAddress'];
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

      $result->group = array();
      $groupResult = mysqli_query($conn, $groupQuery);
      while($members = mysqli_fetch_array($groupResult))
      {
        array_push($result->group, new Contact($members['emailAddress'], $members['phoneNumber']));
      }
    }
    return $result;
  }

  function removeQueuedMessage($messageId)
  {
    $delQuery =
    "DELETE 
        FROM
        Queue
      WHERE
        messageId = '$messageId'
    ;";

    $updtQuery =
    "UPDATE
        Message
      SET
        lastSent = sysdate()
      WHERE
        messageId = '$messageId'
    ;";

    $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

    if(!$conn)
    {
      die('Unable to connect: ' . mysql_error($conn));
    }

    $delResult = mysqli_query($conn, $delQuery);
    $updtResult = mysqli_query($conn, $updtQuery);

    /*if($delResult)
    {
      echo "message " . $messageId . " deleted.\n\n";
    }
    else
    {
      echo "Error: message " . $messageId . " not deleted.\n\n";
    }*/
  }

  while(!$forceExit)
  {
    if(hasMessage())
    {
      while(hasMessage() && !$forceExit)
      {
        $allowExit = false;
        $message = getNextMessage();

        /*echo "MessageId:    " . $message->id . "\n";
        echo "firstName:    " . $message->firstName . "\n";
        echo "lastName:     " . $message->lastName . "\n";
        echo "email:        " . $message->emailAddress . "\n";
        echo "phoneNumber:  " . $message->phoneNumber . "\n";
        $groupLength = count($message->group);
        echo "group:        " . "\n";
        for($i = 0; $i < $groupLength; $i++)
        {
          echo "     " . $message->group[$i]->email . ", " . $message->group[$i]->phone . "\n";
        }
        echo "subject:      " . $message->subject . "\n";
        echo "content:      " . $message->content . "\n\n";*/

        removeQueuedMessage($message->id);
        $allowExit = true;
      }
    }
    else
    {
      sleep(SLEEP_INTERVAL);
    }
  }
?>