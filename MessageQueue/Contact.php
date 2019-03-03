<?php
  class Contact
  {
    private $email;
    private $phone;

    function __construct($email, $phone)
    {
      $this->email = $email;
      $this->phone = $phone;
    }
  }

  function setEmail($email)
  {
    $this->email = $email;
  }

  function setPhone($phone)
  {
    $this->phone = $phone;
  }

  function getEmail()
  {
    return $this->email;
  }

  function getPhone()
  {
    return $this->phone;
  }
?>