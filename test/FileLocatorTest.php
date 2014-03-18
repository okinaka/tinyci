<?php
namespace TinyCI;

class FileLocatorTest extends \PHPUnit_Framework_TestCase
{
    public function testLocate()
    {
        $sut = new FileLocator(__DIR__);
        $actual = $sut->locate('FileLocatorTest.php');
        $this->assertThat($actual, $this->equalTo(__FILE__));

        $sut = new FileLocator(dirname(__DIR__));
        $actual = $sut->locate('phpunit');
        $expected = dirname(__DIR__) . '/vendor/bin/phpunit';
        $this->assertThat($actual, $this->equalTo($expected));
    }
}
