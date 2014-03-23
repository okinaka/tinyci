<?php
namespace TinyCI;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $project = new Project();
        $project->id = 1;
        $project->config = new Config();
        $project->repository = 'https://github.com/okinaka/tinyci.git';
        $project->branch = 'master';

        $build = new Build($project);
        $build->id = 1;

        $this->sut = new Builder($build);
    }

    public function testCreateAndDeleteWorkingCopy()
    {
        $actual = $this->sut->createWorkingCopy();
        $this->assertThat($actual, $this->isTrue());

        $stageConfig = $this->sut->getStageConfig();
        $actual = $this->sut->executeStage('setup', $stageConfig);
        $this->assertThat($actual, $this->isTrue());

        $actual = $this->sut->deleteWorkingCopy();
        $this->assertThat($actual, $this->isTrue());
    }

    public function testToCamelCase()
    {
        $names = [
          'composer' => 'Composer',
          'php_code_sniffer' => 'PhpCodeSniffer',
          'php_unit' => 'PhpUnit',
        ];
        foreach ($names as $name => $expected) {
            $actual = $this->sut->toCamelCase($name);
            $this->assertThat($actual, $this->equalTo($expected));
        }
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
        $actual = $this->sut->execute();
        $this->assertThat($actual, $this->isTrue());
    }
}
