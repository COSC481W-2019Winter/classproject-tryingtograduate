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

    public function setId(int $id): void
    {
      $this->id = $id;
    }

    public function setName(string $name): void
    {
      $this->name = $name;
    }

    public function setEmail(string $email): void
    {
      $this->email = $email;
    }

    public function getId(): int
    {
      return $this->id;
    }

    public function getName(): string
    {
      return $this->name;
    }

    public function getEmail(): string
    {
      return $this->email;
    }
  }
?>