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
        $this->baseBuildDir = APP . '/build';
    }
}
