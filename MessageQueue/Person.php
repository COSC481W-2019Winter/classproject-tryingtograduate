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

    public function setId(int $id): void
    {
      $this->id = $id;
    }

    public function setFirstName(string $firstName): void
    {
      $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
      $this->lastName = $lastName;
    }

    public function setEmail(string $email): void
    {
      $this->email = $email;
    }

    public function setVerCode(int $vCode): void
    {
      if($this->isUser)
      {
        $this->vCode = $vCode;
      }
    }

    public function setVerCodeExp(DateTime $vCodeExp): void
    {
      if($this->isUser)
      {
        $this->vCodeExp = $vCodeExp;
      }
    }

    public function setPasswdHash(string $passwdHash): void
    {
      if($this->isUser)
      {
        $this->passwdHash = $passwdHash;
      }
    }

    public function setPhone(string $phone): void
    {
      $this->phone = $phone;
    }

    public function setCarrier(Carrier $carrier): void
    {
      if($this->isUser && $this->phone)
      {
        $this->carrier = $carrier;
      }
    }

    public function setIsUser($isUser): void
    {
      if($ownerId == null)
      {
        $this->isUser = $isUser;
      }
    }

    public function setOwner($ownerId): void
    {
      if(!$this->isUser)
      {
        $this->ownerId = $ownerId;
      }
    }

    public function getId(): ?int
    {
      return $this->id;
    }

    public function getFirstName(): ?string
    {
      return $this->firstName;
    }

    public function getLastName(): ?string
    {
      return $this->lastName;
    }

    public function getEmail(): ?string
    {
      return $this->email;
    }

    public function getVerCode(): ?int
    {
      return $this->vCode;
    }

    public function getVerCodeExp(): ?DateTime
    {
      return $this->vCodeExp;
    }

    public function getPasswdHash(): ?string
    {
      return $this->passwdHash;
    }

    public function getPhone(): ?string
    {
      return $this->phone;
    }

    public function getCarrier(): ?Carrier
    {
      return $this->carrier;
    }

    public function isUser(): ?bool
    {
      return $this->isUser;
    }

    public function getOwner(): ?int
    {
      return $this->ownerId;
    }
  }
?>