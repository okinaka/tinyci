<?php
namespace TinyCI\Task;

use Symfony\Component\Process\Process;
use TinyCI\Build;
use TinyCI\FileLocator;

class Composer
{
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

    private function runProcess($cmd)
    {
        $process = new Process($cmd);
        $process->setTimeout(3600);
        $process->run();
        return $process->isSuccessful();
    }
}
