<?php
namespace TinyCI;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $project = new Project();
        $build = new Build($project);
        $this->sut = new Builder($build);
    }

    public function testExecute()
    {
        $this->sut->execute();
    }
}
