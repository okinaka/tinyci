<?php
namespace TinyCI;

use Symfony\Component\Process\Process;

trait ProcessTrait
{
    private function runProcess($cmd)
    {
        $process = new Process($cmd);
        $process->setTimeout(3600);
        $process->run();
        return $process->isSuccessful();
    }
}
