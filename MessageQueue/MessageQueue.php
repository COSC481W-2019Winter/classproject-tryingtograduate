<?php
  include('Database.php');
  include('QueueConfig.php');
  include('Message.php');
  include('Person.php');
  include('Carrier.php');
  include('Group.php');
  include('Mail.php');

  $mail = new Mail();

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

  function getNextMessage()
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
    $firstName = $rawMessage['firstName'];
    $lastName = $rawMessage['lastName'];
    $emailAddress = $rawMessage['emailAddress'];
    $phoneNumber = $rawMessage['phoneNumber'];
    $carrierId = $rawMessage['carrierId'];
    $groupId = $rawMessage['groupId'];
    $groupName = $rawMessage['groupName'];
    $subject = $rawMessage['subject'];
    $content = $rawMessage['content'];

    $user = new Person($ownerId,
                       $firstName,
                       $lastName,
                       $emailAddress,
                       null, null, null,
                       $phoneNumber,
                       null, true, null);

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

      $groupMembers = array();
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

  function removeQueuedMessage($messageId)
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

    $dateQuery =
    "SELECT
        lastSent
      FROM
        Message
      WHERE
        messageId = '$messageId'
    ;";

    $delResult = mysqli_query($conn, $delQuery);
    $updtResult = mysqli_query($conn, $updtQuery);
    $dateResult = mysqli_query($conn, $dateQuery);
    $rawDate = mysqli_fetch_array($dateResult);
    return $rawDate['lastSent'];

  }

  while(!$forceExit)
  {
    if(hasMessage())
    {
      while(hasMessage() && !$forceExit)
      {
        $allowExit = false;
        $message = getNextMessage();

        $messageId = $message->getId();
        $senderAddress = $message->getUser()->getEmail();

        $fullName = $message->getUser()->getFirstName();
        $fullName .= " ";
        $fullName .= $message->getUser()->getLastName();

        $groupId = $message->getGroup()->getId();
        $group = $message->getGroup()->getMembers();
        $recipients = array();
        $groupLength = count($group);
        for($i = 0; $i < $groupLength; $i++)
        {
          // TODO: build logic to determine whether to send SMS instead of email.
          $recipients[$i] = $group[$i]->getEmail();
        }
        $subject = $message->getSubject();
        $content = $message->getContent();
        
        $success = $mail->sendMail($senderAddress,
                                  $fullName,
                                  $recipients,
                                  $subject,
                                  $content);

        $sendDate = removeQueuedMessage($message->getId());

        $logEntry = $sendDate;
        $logEntry .= " MessageId: ";
        $logEntry .= $messageId; 
        $logEntry .= " UserId: ";
        $logEntry .= $senderAddress;
        $logEntry .= " Send Status:";

        $reportBody = " Message with subject \"";
        $reportBody .= $subject;
        

        if($success)
        {
          $logEntry .= " Success\n";
          $reportBody .= "\" was sent";
        }
        else
        {
          $logEntry .= " Failure\n";
          $reportBody .= "\" was not sent";
        }
        $reportBody .=" successfully.";
        echo $logEntry;

        $sender = array();
        $sender[0] = $senderAddress;
        $mail->sendMail("jpeck3@emich.edu",
                        "Carrier Pigeon",
                        $sender,
                        "Carrier Pigeon Message Report",
                        $reportBody);

        $allowExit = true;
      }
    }
    else
    {
      sleep(SLEEP_INTERVAL);
    }
  }
?>