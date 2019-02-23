<?php
  include('Message.php');

  $Message = new Message();

  $Message->getNextMessage();

  echo "MessageId:    " . $Message->id . "\n";
  echo "firstName:    " . $Message->firstName . "\n";
  echo "lastName:     " . $Message->lastName . "\n";
  echo "email:        " . $Message->emailAddress . "\n";
  echo "phoneNumber:  " . $Message->phoneNumber . "\n";
  $groupLength = count($Message->group);
  echo "group:        " . "\n";
  for($i = 0; $i < $groupLength; $i++)
  {
    echo "     " . $Message->group[$i]->email . ", " . $Message->group[$i]->phone . "\n";
  }
  echo "subject:      " . $Message->subject . "\n";
  echo "content:      " . $Message->content . "\n";
?>