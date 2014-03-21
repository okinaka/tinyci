<?php
namespace TinyCI\Task;

use TinyCI\Build;
use TinyCI\FileLocator;
use TinyCI\ProcessTrait;

class Composer
{
    use ProcessTrait;

    public function __construct(Build $build, $option)
    {
        $this->build = $build;
        $this->action = isset($option['action']) ? $option['action'] : 'install';
    }

    public function execute()
    {
        $dir = $this->build->dir();
        $cmd = $this->locateCommand()
            . " --no-ansi --no-interaction --working-dir=\"{$dir}\" "
            . $this->action;
        return $this->runProcess($cmd);
    }

    private function locateCommand()
    {
        $locator = new FileLocator(APP);
        $cmd = $locator->locate(['composer', 'composer.phar']);
        if (!is_executable($cmd)) {
            $cmd = 'php ' . $cmd;
        }
        return $cmd;
    }
}
