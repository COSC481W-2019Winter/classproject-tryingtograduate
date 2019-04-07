<?php
class recipient
{
  private $address;
  private $name;

  public function __construct($firstName, $lastName, $emailAddress)
  {
    $this->email = $emailAddress;
    $this->name = $firstName;
    $this->name .= " ";
    $this->name .= $lastName;
  }

  public function getAddress()
  {
    return $this->address;
  }

  public function getName()
  {
    return $this->name;
  }
}
?>