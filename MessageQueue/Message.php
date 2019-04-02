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

    public function setId(int $id)
    {
      $this->id = $id;
    }

    public function setUser(Person $user)
    {
      $this->user = $user;
    }

    public function setGroup(Group $group)
    {
      $this->group = $group;
    }

    public function setSubject(string $subject)
    {
      $this->subject = $subject;
    }

    public function setContent(string $content)
    {
      $this->content = $content;
    }

    public function getId()
    {
      return $this->id;
    }

    public function getUser()
    {
      return $this->user;
    }

    public function getGroup()
    {
      return $this->group;
    }

    public function getSubject()
    {
      return $this->subject;
    }

    public function getContent()
    {
      return $this->content;
    }
  }
?>