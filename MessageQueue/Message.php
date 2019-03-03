<?php
  class Message
  {
    private $id;
    private $firstName;
    private $lastName;
    private $emailAddress;
    private $phoneNumber;
    private $carrierEmail;
    private $group;
    private $subject;
    private $content;

    function __construct()
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

    function setId($id)
    {
      $this->id = $id;
    }

    function setFirstName($firstName)
    {
      $this->firstName = $firstName;
    }

    function setLastName($lastName)
    {
      $this->lastName = $lastName;
    }

    function setEmail($email)
    {
      $this->emailAddress = $email;
    }

    function setPhone($phone)
    {
      $this->phoneNumber = $phone;
    }

    function setCarrierEmail($carrierEmail)
    {
      $this->carrierEmail = $carrierEmail;
    }

    function setGroup($groupId)
    {
      $this->group = $groupId;
    }

    function setSubject($subject)
    {
      $this->subject = $subject;
    }

    function setContent($content)
    {
      $this->content = $content;
    }

    function getId()
    {
      return $this->id;
    }

    function getFirstName()
    {
      return $this->firstName;
    }

    function getLastName()
    {
      return $this->lastName;
    }

    function getEmail()
    {
      return $this->emailAddress;
    }

    function getPhone()
    {
      return $this->phoneNumber;
    }

    function getCarrierEmail()
    {
      return $this->carrierEmail;
    }

    function getGroup()
    {
      return $this->group;
    }

    function getSubject()
    {
      return $this->subject;
    }

    function getContent()
    {
      return $this->content;
    }
  }
?>