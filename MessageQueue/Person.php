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

    public function __construct(int $id,
                                string $firstName = null,
                                string $lastName = null, 
                                string $email = null,
                                int $vCode = null,
                                DateTime $vCodeExp = null,
                                string $passwdHash = null,
                                string $phone = null,
                                Carrier $carrier = null,
                                bool $isUser,
                                int $ownerId = null)
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

    public function setId(int $id)
    {
      $this->id = $id;
    }

    public function setFirstName(string $firstName)
    {
      $this->firstName = $firstName;
    }

    public function setLastName(string $lastName)
    {
      $this->lastName = $lastName;
    }

    public function setEmail(string $email)
    {
      $this->email = $email;
    }

    public function setVerCode(int $vCode)
    {
      if($this->isUser)
      {
        $this->vCode = $vCode;
      }
    }

    public function setVerCodeExp(DateTime $vCodeExp)
    {
      if($this->isUser)
      {
        $this->vCodeExp = $vCodeExp;
      }
    }

    public function setPasswdHash(string $passwdHash)
    {
      if($this->isUser)
      {
        $this->passwdHash = $passwdHash;
      }
    }

    public function setPhone(string $phone)
    {
      $this->phone = $phone;
    }

    public function setCarrier(Carrier $carrier)
    {
      if($this->isUser && $this->phone)
      {
        $this->carrier = $carrier;
      }
    }

    public function setIsUser(bool $isUser)
    {
      if($ownerId == null)
      {
        $this->isUser = $isUser;
      }
    }

    public function setOwner(int $ownerId)
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