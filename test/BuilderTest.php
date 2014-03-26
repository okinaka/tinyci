<?php
namespace TinyCI;

use Monolog\Logger;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        $logger = new Logger('BuilderTest');

        $project = new Project();
        $project->id = 1;
        $project->config = new Config();
        $project->repository = 'https://github.com/okinaka/tinyci.git';
        $project->branch = 'master';

        $build = new Build($project);
        $build->id = 1;

        $this->sut = new Builder($build);
        $this->sut->setLogger($logger);
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

    public function testExecute()
    {
        $actual = $this->sut->execute();
        $this->assertThat($actual, $this->isTrue());
    }
}
