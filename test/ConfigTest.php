<?php
namespace TinyCI;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->sut = new Config();
    }

    public function testBaseBuildDir()
    {
        $this->assertThat($this->sut->baseBuildDir, $this->equalTo(dirname(__DIR__) . '/build'));
    }
}
