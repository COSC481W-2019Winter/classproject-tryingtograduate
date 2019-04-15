<?php
  use PHPUnit\Framework\TestCase;

  const GID = 100;
  const GNAME = "Group 1";
  const GOWNER = 5;
  const ALTGID = 200;
  const ALTGNAME = "Alternate Group";
  const ALTGOWN = 15;

  class GroupTest extends TestCase
  {
    protected $group;

    protected $gMembers;

    protected function setUp(): void 
    {
      $this->group = new Group(GID, GNAME, GOWNER, null);

      $this->gMembers = [];
    }

    public function testGroup(): void
    {
      $this->assertTrue($this->group->getId() == GID
                      && $this->group->getName() == GNAME
                      && $this->group->getOwnerId() == GOWNER);
    }

    public function testSetGetId(): void
    {
      $this->group->setId(ALTGID);
      $this->assertTrue($this->group->getId() == ALTGID);
    }

    public function testSetGetName(): void
    {
      $this->group->setName(ALTGNAME);
      $this->assertTrue($this->group->getName() == ALTGNAME);
    }

    public function testSetGetOwnerId(): void
    {
      $this->group->setOwnerId(ALTGID);
      $this->assertTrue($this->group->getOwnerId() == ALTGID);
    }

    public function testSetGetMembers(): void
    {
      $this->group->setMembers($this->gMembers);
      $this->assertTrue($this->group->getMembers() === $this->gMembers);
    }
  }
?>