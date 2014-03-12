<?php
namespace TinyCI;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->sut = new Builder();
    }

    public function testExecute()
    {
        $this->sut->execute();
    }
}
