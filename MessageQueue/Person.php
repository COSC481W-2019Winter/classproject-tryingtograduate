<?php
  class Person
  {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $vCode;
    private $vCodeExp;
    private $passwdHash;
    private $phone;
    private $carrier;
    private $isUser;
    private $ownerId;

    public function __construct($id,
                                $firstName = null,
                                $lastName = null, 
                                $email = null,
                                $vCode = null,
                                $vCodeExp = null,
                                $passwdHash = null,
                                $phone = null,
                                $carrier = null,
                                $isUser,
                                $ownerId = null)
    {
      $this->id = $id;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->vCode = $vCode;
      $this->vCodeExp = $vCodeExp;
      $this->passwdHash = $passwdHash;
      $this->carrier = $carrier;
      $this->phone = $phone;
      $this->isUser = $isUser;
      $this->ownerId = $ownerId;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function setFirstName($firstName)
    {
      $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
      $this->lastName = $lastName;
    }

    public function setEmail($email)
    {
      $this->email = $email;
    }

    public function setVerCode($vCode)
    {
      if($this->isUser)
      {
        $this->vCode = $vCode;
      }
    }

    public function setVerCodeExp($vCodeExp)
    {
      if($this->isUser)
      {
        $this->vCodeExp = $vCodeExp;
      }
    }

    public function setPasswdHash($passwdHash)
    {
      if($this->isUser)
      {
        $this->passwdHash = $passwdHash;
      }
    }

    public function setPhone($phone)
    {
      $this->phone = $phone;
    }

    public function setCarrier($carrier)
    {
      if($this->isUser && $this->phone)
      {
        $this->carrier = $carrier;
      }
    }

    public function setIsUser($isUser)
    {
      if($ownerId == null)
      {
        $this->isUser = $isUser;
      }
    }

    public function setOwner($ownerId)
    {
      if(!$this->isUser)
      {
        $this->ownerId = $ownerId;
      }
    }

    public function getId()
    {
      return $this->id;
    }

    public function getFirstName()
    {
      return $this->firstName;
    }

    public function getLastName()
    {
      return $this->lastName;
    }

    public function getEmail()
    {
      return $this->email;
    }

    public function getVerCode()
    {
      return $this->vCode;
    }

    public function getVerCodeExp()
    {
      return $this->vCodeExp;
    }

    public function getPasswdHash()
    {
      return $this->passwdHash;
    }

    public function getPhone()
    {
      return $this->phone;
    }

    public function getCarrier()
    {
      return $this->carrier;
    }

    public function isUser()
    {
      return $this->isUser;
    }

    public function getOwner()
    {
      return $this->ownerId;
    }
  }
?>