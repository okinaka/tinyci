<?php
namespace TinyCI;

class Config
{
    /**
     * @var string
     */
    public $baseBuildDir = null;

    public function __construct()
    {
        $this->baseBuildDir = dirname(__DIR__) . '/build';
    }
}
