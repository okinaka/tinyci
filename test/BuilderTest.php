<?php
namespace TinyCI;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $config = new Config();
        $project = new Project();
        $project->id = 1;
        $build = new Build($project);
        $build->id = 1;
        $this->sut = new Builder($config, $build);
    }

    public function testGetBuildDir()
    {
        $actual = $this->sut->getBuildDir();
        $expected = dirname(__DIR__) . '/build/project1-build1';
        $this->assertThat($actual, $this->equalTo($expected));
    }

    public function testExecute()
    {
        $this->sut->execute();
    }
}
