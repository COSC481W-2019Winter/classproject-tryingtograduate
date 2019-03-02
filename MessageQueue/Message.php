<?php
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
  }
?>