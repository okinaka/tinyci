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
        $project->repository = 'https://github.com/okinaka/tinyci.git';
        $project->branch = 'master';

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

    public function testCreateAndDeleteWorkingCopy()
    {
        $actual = $this->sut->createWorkingCopy();
        $this->assertThat($actual, $this->isTrue());

        $actual = $this->sut->deleteWorkingCopy();
        $this->assertThat($actual, $this->isTrue());
    }

    public function testLog()
    {
        $message = 'log';
        $expected = "log\n";

        ob_start();
        $this->sut->log($message);
        $actual = ob_get_contents();
        ob_end_clean();

        $this->assertThat($actual, $this->equalTo($expected));
    }

    public function testExecute()
    {
        $this->sut->execute();
    }
}
