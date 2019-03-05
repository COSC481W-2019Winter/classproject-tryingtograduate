<?php
  include('Database.php');
  include('QueueConfig.php');
  include('Message.php');
  include('Person.php');
  include('Carrier.php');
  include('Group.php');

  $conn = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

  if(!$conn)
  {
    die('Unable to connect: ' . mysql_error($conn));
  }

  $allowExit = true;
  $forceExit = false;

  declare(ticks = 1);

  register_tick_function('checkExit');

  pcntl_signal(SIGTERM, "signalHandler");
  pcntl_signal(SIGHUP, "signalHandler");

  function signalHandler($signal): void
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

  function checkExit(): void
  {
    global $allow_exit, $force_exit;

    if ($force_exit && $allow_exit)
    {
      exit;
    }
  }

  function hasMessage(): bool
  {
    global $conn;

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

  function getNextMessage(): ?Message
  {
    global $conn;

    $messageQuery =
    "SELECT
          Queue.messageId AS messageId,
          uniqueId,
          firstName,
          lastName,
          emailAddress,
          phoneNumber,
          carrierId,
          Message.groupId AS groupId,
          groupName,
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
              groupId,
              groupName
            FROM
              Groups
        ) AS Groups
        ON
          Message.groupId = Groups.groupId
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

    $messageId = $rawMessage['messageId'];
    $ownerId = $rawMessage['uniqueId'];
    $user = new Person($ownerId,
                       $rawMessage['firstName'],
                       $rawMessage['lastName'],
                       $rawMessage['emailAddress'],
                       $rawMessage['phoneNumber'],
                       null, true, null);
    $carrierId = $rawMessage['carrierId'];
    $groupId = $rawMessage['groupId'];
    $groupName = $rawMessage['groupName'];
    $subject = $rawMessage['subject'];
    $content = $rawMessage['content'];

    if($carrierId != null)
    {
      $carrierQuery =
      "SELECT
          carrierName,
          emailAddress
        FROM
          Carrier
        WHERE
          carrierId = '$carrierId'
      ;";
      
      $carrierResult = mysqli_query($conn, $carrierQuery);
      $rawCarrier = mysqli_fetch_array($carrierResult);

      $carrier = new Carrier($carrierId,
                  $rawCarrier['carrierName'],
                  $rawCarrier['emailAddress']);

      $user->setCarrier($carrier);
    }

    $result = new Message($messageId,
                          $user,
                          null,
                          $subject,
                          $content);

    if($groupId == null)
    {
      die('No group assigned to message');
    }
    else
    {
      $groupQuery =
      "SELECT
          uniqueId,
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

      $groupMembers = [];
      $groupResult = mysqli_query($conn, $groupQuery);
      $currPerson = null;
      while($members = mysqli_fetch_array($groupResult))
      {
        $currPerson = new Person($members['uniqueId'],
                                null, null,
                                $members['emailAddress'],
                                null, null, null,
                                $members['phoneNumber'],
                                null, false, $ownerId);

        array_push($groupMembers, $currPerson);
      }

      $group = new Group($groupId,
                         $groupName,
                         $ownerId,
                         $groupMembers);

      $result->setGroup($group);
    }
    return $result;
  }

  function removeQueuedMessage($messageId): void
  {
    global $conn;

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

    $delResult = mysqli_query($conn, $delQuery);
    $updtResult = mysqli_query($conn, $updtQuery);
  }

  while(!$forceExit)
  {
    if(hasMessage())
    {
      while(hasMessage() && !$forceExit)
      {
        $allowExit = false;
        $message = getNextMessage();

        /*echo "MessageId:    " . $message->getId() . "\n";
        echo "firstName:    " . $message->getFirstName() . "\n";
        echo "lastName:     " . $message->getLastName() . "\n";
        echo "email:        " . $message->getEmailAddress() . "\n";
        echo "phoneNumber:  " . $message->getPhoneNumber() . "\n";
        $group = $message->getGroup();
        $groupLength = count($group);
        echo "group:        " . "\n";
        for($i = 0; $i < $groupLength; $i++)
        {
          echo "     " . $group[$i]->email . ", " . $group[$i]->phone . "\n";
        }
        echo "subject:      " . $message->getSubject() . "\n";
        echo "content:      " . $message->getContent() . "\n\n";*/

        removeQueuedMessage($message->getId());
        $allowExit = true;
      }
    }
    else
    {
      sleep(SLEEP_INTERVAL);
    }
  }
?>