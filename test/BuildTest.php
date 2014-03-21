<?php
namespace TinyCI;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $project = new Project();
        $project->id = 1;
        $project->config = new Config();
        $project->repository = 'https://github.com/okinaka/tinyci.git';
        $project->branch = 'master';

        $this->sut = new Build($project);
        $this->sut->id = 1;
    }

    public function testDir()
    {
        $actual = $this->sut->dir();
        $expected = dirname(__DIR__) . '/build/project1-build1';
        $this->assertThat($actual, $this->equalTo($expected));
    }

    public function testCreateAndDeleteWorkingCopy()
    {
        $actual = $this->sut->createWorkingCopy();
        $this->assertThat($actual, $this->isTrue());

        $actual = $this->sut->deleteWorkingCopy();
        $this->assertThat($actual, $this->isTrue());
    }
}
