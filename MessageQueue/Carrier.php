<?php
  class Carrier
  {
    private $id;
    private $name;
    private $email;

    public function __construct($id,
                                $name,
                                $email)
    {
      $this->id = $id;
      $this->name = $name;
      $this->email = $email;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function setName($name)
    {
      $this->name = $name;
    }

    public function setEmail($email)
    {
      $this->email = $email;
    }

    public function getId()
    {
      return $this->id;
    }

    public function getName()
    {
      return $this->name;
    }

    public function getEmail()
    {
      return $this->email;
    }
  }
?>