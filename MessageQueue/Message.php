<?php
  class Message
  {
    private $id;
    private $user;
    private $group;
    private $subject;
    private $content;

    public function __construct($id,
                                $user,
                                $group = null,
                                $subject,
                                $content)
    {
      $this->id = $id;
      $this->user = $user;
      $this->group = $group;
      $this->subject = $subject;
      $this->content = $content;
    }

    public function setId($id)
    {
      $this->id = $id;
    }

    public function setUser($user)
    {
      $this->user = $user;
    }

    public function setGroup($group)
    {
      $this->group = $group;
    }

    public function setSubject($subject)
    {
      $this->subject = $subject;
    }

    public function setContent($content)
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