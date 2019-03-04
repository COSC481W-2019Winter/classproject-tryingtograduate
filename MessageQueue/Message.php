<?php
  class Message
  {
    private $id;
    private $user;
    private $group;
    private $subject;
    private $content;

    public function __construct(int $id,
                                Person $user,
                                Group $group = null,
                                string $subject,
                                string $content)
    {
      $this->id = $id;
      $this->user = $user;
      $this->group = $group;
      $this->subject = $subject;
      $this->content = $content;
    }

    public function setId(int $id): void
    {
      $this->id = $id;
    }

    public function setUser(Person $user): void
    {
      $this->user = $user;
    }

    public function setGroup(Group $group): void
    {
      $this->group = $group;
    }

    public function setSubject(string $subject): void
    {
      $this->subject = $subject;
    }

    public function setContent(string $content): void
    {
      $this->content = $content;
    }

    public function getId(): int
    {
      return $this->id;
    }

    public function getUser(): Person
    {
      return $this->user;
    }

    public function getGroup(): ?Group
    {
      return $this->group;
    }

    public function getSubject(): string
    {
      return $this->subject;
    }

    public function getContent(): string
    {
      return $this->content;
    }
  }
?>