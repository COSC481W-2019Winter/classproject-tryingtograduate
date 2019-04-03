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

    public function setId(int $id)
    {
      $this->id = $id;
    }

    public function setName(string $name)
    {
      $this->name = $name;
    }

    public function setOwnerId(int $ownerId)
    {
      $this->ownerId = $ownerId;
    }

    public function setMembers(array $members)
    {
      $this->members = $members;
    }

    public function getId()
    {
      return $this->id;
    }

    public function getName()
    {
      return $this->name;
    }

    public function getOwnerId()
    {
      return $this->ownerId;
    }

    public function getmembers()
    {
      return $this->members;
    }
  }
?>