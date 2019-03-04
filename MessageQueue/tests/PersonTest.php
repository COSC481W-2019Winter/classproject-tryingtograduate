<?php
  use PHPUnit\Framework\TestCase;

  const ID = 1;
  const FIRST = "First";
  const LAST = "Last";
  const EMAIL = "test@email.com";
  const CODE = 9999;
  const PASS = "FFFF";
  const PHONE = "1-234-567-8900";
  const OWNER = 2;
  const ALTOWN = 3;


  class PersonTest extends TestCase
  {
    protected $minUser;
    protected $fullUser;
    protected $minContact;
    protected $fullContact;

    protected function setUp(): void
    {
      $this->minUser = new Person(ID, null, null,
                                  EMAIL, null, null,
                                  null, null, null,
                                  true, null);

      $this->fullUser = new Person(ID, FIRST, LAST,
                                  EMAIL, CODE, null,
                                  PASS, PHONE, null,
                                  true, null);

      $this->minContact = new Person(ID, null, null,
                                    EMAIL, null, null,
                                    null, null, null,
                                    false, OWNER);

      $this->fullContact = new Person(ID, FIRST, LAST,
                                      EMAIL, null, null,
                                      null, PHONE, null,
                                      false, OWNER);
    }

    public function testMinUser(): void
    {
      $this->assertTrue($this->minUser->getId() == ID
                    && $this->minUser->getFirstName() == null
                    && $this->minUser->getLastName() == null
                    && $this->minUser->getEmail() == EMAIL
                    && $this->minUser->getVerCode() == null
                    && $this->minUser->getVerCodeExp() == null
                    && $this->minUser->getPasswdHash() == null
                    && $this->minUser->getPhone() == null
                    && $this->minUser->getCarrier() == null
                    && $this->minUser->IsUser() == true
                    && $this->minUser->getOwner() == null);
    }

    public function testFullUser(): void
    {
      $this->assertTrue($this->fullUser->getId() == ID
                    && $this->fullUser->getFirstName() == FIRST
                    && $this->fullUser->getLastName() == LAST
                    && $this->fullUser->getEmail() == EMAIL
                    && $this->fullUser->getVerCode() == CODE
                    && $this->fullUser->getVerCodeExp() == null 
                    && $this->fullUser->getPasswdHash() == PASS 
                    && $this->fullUser->getPhone() == PHONE 
                    && $this->fullUser->getCarrier() == null
                    && $this->fullUser->IsUser() == true
                    && $this->fullUser->getOwner() == null);
    }

    public function testMinContact(): void
    {
      $this->assertTrue($this->minContact->getId() == ID
                    && $this->minContact->getFirstName() == null
                    && $this->minContact->getLastName() == null
                    && $this->minContact->getEmail() == EMAIL
                    && $this->minContact->getVerCode() == null
                    && $this->minContact->getVerCodeExp() == null
                    && $this->minContact->getPasswdHash() == null
                    && $this->minContact->getPhone() == null
                    && $this->minContact->getCarrier() == null
                    && $this->minContact->IsUser() == false
                    && $this->minContact->getOwner() == OWNER);
    }

    public function testFullContact(): void
    {
      $this->assertTrue($this->fullContact->getId() == ID
                    && $this->fullContact->getFirstName() == FIRST
                    && $this->fullContact->getLastName() == LAST
                    && $this->fullContact->getEmail() == EMAIL
                    && $this->fullContact->getVerCode() == null
                    && $this->fullContact->getVerCodeExp() == null
                    && $this->fullContact->getPasswdHash() == null
                    && $this->fullContact->getPhone() == PHONE
                    && $this->fullContact->getCarrier() == null
                    && $this->fullContact->IsUser() == false
                    && $this->fullContact->getOwner() == OWNER);
    }

    public function testSetGetId(): void
    {
      $this->minUser->setId(OWNER);
      $this->assertTrue($this->minUser->getId() == OWNER);
    }

    public function testSetGetFirstName(): void
    {
      $this->minUser->setFirstName(FIRST);
      $this->assertTrue($this->minUser->getFirstName() == FIRST);
    }

    public function testSetGetLastName(): void
    {
      $this->minUser->setLastName(LAST);
      $this->assertTrue($this->minUser->getLastName() == LAST);
    }

    public function testSetGetEmail(): void
    {
      $this->minUser->setEmail(EMAIL);
      $this->assertTrue($this->minUser->getEmail() == EMAIL);
    }

    public function testSetGetVerCode(): void
    {
      $this->minUser->setVerCode(CODE);
      $this->assertTrue($this->minUser->getVerCode() == CODE);
    }

    public function testSetGetPasswdHash(): void
    {
      $this->minUser->setPasswdHash(PASS);
      $this->assertTrue($this->minUser->getPasswdHash() == PASS);
    }

    public function testSetGetPhone(): void
    {
      $this->minUser->setPhone(PHONE);
      $this->assertTrue($this->minUser->getPhone() == PHONE);
    }

    public function testSetGetOwner(): void
    {
      $this->minContact->setOwner(ALTOWN);
      $this->assertTrue($this->minContact->getOwner() == ALTOWN);
    }
  }
?>