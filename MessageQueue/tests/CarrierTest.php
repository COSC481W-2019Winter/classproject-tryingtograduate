<?php
  use PHPUnit\Framework\TestCase;

  const CID = 1;
  const NAME = "PhoneCo";
  const CEMAIL = "@phoneco.net";
  const ALTCID = "2";
  const ALTNAME = "CellInc";
  const ALTCEMAIL = "@cellinc.com";

  class CarrierTest extends TestCase
  {
    protected $provider;

    protected function setUp(): void 
    {
      $this->carrier = new Carrier(CID, NAME, CEMAIL);
    }

    public function testCarrier(): void
    {
      $this->assertTrue($this->carrier->getId() == CID
                      && $this->carrier->getName() == NAME
                      && $this->carrier->getEmail() == CEMAIL);
    }

    public function testSetGetId(): void
    {
      $this->carrier->setId(ALTCID);
      $this->assertTrue($this->carrier->getId() == ALTCID);
    }

    public function testSetGetName(): void
    {
      $this->carrier->setName(ALTNAME);
      $this->assertTrue($this->carrier->getName() == ALTNAME);
    }

    public function testSetGetEmail(): void
    {
      $this->carrier->setEmail(ALTCEMAIL);
      $this->assertTrue($this->carrier->getEmail() == ALTCEMAIL);
    }
  }
?>