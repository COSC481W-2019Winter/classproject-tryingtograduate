<?php
  class Group
  {
    private $id;
    private $name;
    private $ownerId;
    private $members;

    public function __construct($id,
                                $name,
                                $ownerId,
                                $members = null)
    {
      $this->id = $id;
      $this->name = $name;
      $this->ownerId = $ownerId;
      $this->members = $members;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function setName($name)
    {
      $this->name = $name;
    }

    public function setOwnerId($ownerId)
    {
      $this->ownerId = $ownerId;
    }

    public function setMembers($members)
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