<?php
  class Carrier
  {
    private $id;
    private $name;
    private $email;

    public function __construct(int $id,
                                string $name,
                                string $email)
    {
      $this->id = $id;
      $this->name = $name;
      $this->email = $email;
    }

    public function setId(int $id)
    {
      $this->id = $id;
    }

    public function setName(string $name)
    {
      $this->name = $name;
    }

    public function setEmail(string $email)
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