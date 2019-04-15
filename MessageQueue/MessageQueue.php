<?php
  include('Database.php');
  include('QueueConfig.php');
  include('Message.php');
  include('Person.php');
  include('Carrier.php');
  include('Group.php');
  include('Mail.php');

  $mail = new Mail();

  date_default_timezone_set('UTC');
  $now = new DateTime();

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

  function removeQueuedMessage($messageId)
  {
    global $conn;

    $delQueueEntryQuery =
    "DELETE 
      FROM
        Queue
      WHERE
        messageId = '$messageId'
    ;";

    $delMessageEntryQuery =
    "DELETE
      FROM
        Message
      WHERE
        messageId = '$messageId'
    ;";

    $delResult = mysqli_query($conn, $delQueueEntryQuery);
    $updtResult = mysqli_query($conn, $delMessageEntryQuery);
  }

  function getCarrierSuffix($carrierId)
  {
    global $conn;

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

    $name = $rawCarrier['carrierName'];
    $suffix = $rawCarrier['emailAddress'];

    $carrier = new Carrier($carrierId, $name, $suffix);

    return $carrier;
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
              emailAddress
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
    $groupId = $rawMessage['groupId'];
    $groupName = $rawMessage['groupName'];
    $subject = $rawMessage['subject'];
    $content = $rawMessage['content'];

    $user = new Person($ownerId,
                       $firstName,
                       $lastName,
                       $emailAddress,
                       null, null,
                       null, null,
                       null, null);

    $result = new Message($messageId,
                          $user,
                          null,
                          $subject,
                          $content);

    if($groupId == null)
    {
      echo $now->format('Y-m-d H:i:s');
      echo "Message: ";
      echo $messageId;
      echo " Error: No group assigned to message\n";
      removeQueuedMessage($messageId);
    }
    else
    {
      $groupQuery =
      "SELECT
          uniqueId,
          firstName,
          lastName,
          emailAddress,
          phoneNumber,
          carrierId
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
              firstName,
              lastName,
              emailAddress,
              phoneNumber,
              carrierId
            from
              Person
        ) as Contact
        on
          contactId = uniqueId
      ;";

      $groupMembers = array();
      $groupResult = mysqli_query($conn, $groupQuery);
      $currMember = null;
      while($members = mysqli_fetch_array($groupResult))
      {
        $currMember = new Person($members['uniqueId'],
                                $members['firstName'],
                                $members['lastName'],
                                $members['emailAddress'],
                                null, null, null,
                                $members['phoneNumber'],
                                null, $ownerId);

        $carrierId = $members['carrierId'];

        if($carrierId != 99 && $carrierId != null)
        {
          $carrier = getCarrierSuffix($carrierId);
          $currMember->setCarrier($carrier);
        }

        array_push($groupMembers, $currMember);
      }

      $group = new Group($groupId,
                         $groupName,
                         $ownerId,
                         $groupMembers);

      $result->setGroup($group);
    }
    return $result;
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
        $groupMembers = $message->getGroup()->getMembers();
        $subject = $message->getSubject();
        $content = $message->getContent();
        
        $results = $mail->sendMail($senderAddress,
                                  $fullName,
                                  $groupMembers,
                                  $subject,
                                  $content);

        removeQueuedMessage($message->getId());

        $logEntry = $now->format('Y-m-d H:i:s');
        $logEntry .= " MessageId: ";
        $logEntry .= $messageId; 
        $logEntry .= " UserId: ";
        $logEntry .= $senderAddress;
        $logEntry .= " Send Status:\n";

        $reportBody = " Message with subject \"";
        $reportBody .= $subject;
        $reportBody .= "\"\n\n";
        $reportBody .= "MessageId: ";
        $reportBody .= $messageId;
        $reportBody .= "\n\n";
 
        echo $logEntry;

        $resultCount = count($results);
        if($resultCount > 0)
        {
          for($i = 0; $i < $resultCount; $i++)
          {
            echo "\t" . $results[$i] . "\n";
            $reportBody .= "\t" . $results[$i] . "\n";
          }
        }
        else
        {
          echo GENERAL_FAILURE . "\n";
          $reportBody = GENERAL_FAILURE . "\n";
        }

        $senderGroup = array();
        $senderGroup[0] = $message->getUser();

        $mail->sendMail(SERVICE_EMAIL,
                        SERVICE_NAME,
                        $senderGroup,
                        SERVICE_SUBJECT,
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