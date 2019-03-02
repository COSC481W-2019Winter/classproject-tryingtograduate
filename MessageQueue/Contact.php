<?php
  class Contact
  {
    var $email;
    var $phone;

    function __construct($email, $phone)
    {
      $this->email = $email;
      $this->phone = $phone;
    }
  }
?>