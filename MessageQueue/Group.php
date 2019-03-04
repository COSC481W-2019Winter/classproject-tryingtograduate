<?php
  class Group
  {
    private $id;
    private $name;
    private $ownerId;
    private $members;

    public function __construct(int $id,
                                string $name,
                                int $ownerId,
                                array $members = null)
    {
      $this->id = $id;
      $this->name = $name;
      $this->ownerId = $ownerId;
      $this->members = $members;
    }

    public function setId(int $id): void
    {
      $this->id = $id;
    }

    public function setName(string $name): void
    {
      $this->name = $name;
    }

    public function setOwnerId(int $ownerId): void
    {
      $this->ownerId = $ownerId;
    }

    public function setmembers(array $members): void
    {
      $this->members = $members;
    }

    public function getId(): int
    {
      return $this->id;
    }

    public function getName(): string
    {
      return $this->name;
    }

    public function getOwnerId(): int
    {
      return $this->ownerId;
    }

    public function getmembers(): array
    {
      return $this->members;
    }
  }
?>