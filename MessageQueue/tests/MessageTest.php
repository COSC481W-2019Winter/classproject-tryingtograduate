<?php
  use PHPUnit\Framework\TestCase;

  const MID = 1;
  const MSUBJ = "Message 1";
  const MCONT = "Content 1";
  const ALTMID = 2;
  const ALTMSUBJ = "Alternate Message";
  const ALTMCONT = "Alternate Content";

  class MessageTest extends TestCase
  {
    protected $message;
    protected $mUser;
    protected $altMUser;

    protected function setUp(): void 
    {
     $this->mUser = new Person(10, null, null,
                                  "10@isp.net", null, null,
                                  null, null, null,
                                  true, null);

    $this->altMUser = new Person(20, null, null,
                                  "20@isp.net", null, null,
                                  null, null, null,
                                  true, null);

    $this->message = new Message(MID, $this->mUser,
                                null, MSUBJ, MCONT);
    }

    public function testMessage()
    {
      $this->assertTrue($this->message->getId() == MID
                     && $this->message->getUser() === $this->mUser
                    && $this->message->getSubject() == MSUBJ
                    && $this->message->getContent() == MCONT
                   );
    }

    public function testSetGetId(): void
    {
      $this->message->setId(ALTMID);
      $this->assertTrue($this->message->getId() == ALTMID);
    }

    public function testSetGetUser(): void
    {
      $this->message->setUser($this->altMUser);
      $this->assertTrue($this->message->getUser() === $this->altMUser);
    }

    public function testSetGetSubject(): void
    {
      $this->message->setSubject(ALTMSUBJ);
      $this->assertTrue($this->message->getSubject() == ALTMSUBJ);
    }

    public function testSetGetContent(): void
    {
      $this->message->setContent(ALTMCONT);
      $this->assertTrue($this->message->getContent() == ALTMCONT);
    }
  }
?>