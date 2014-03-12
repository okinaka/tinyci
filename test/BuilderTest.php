<?php
namespace TinyCI;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        $build = new Build();
        $this->sut = new Builder($build);
    }

    public function testExecute()
    {
        $this->sut->execute();
    }
}
