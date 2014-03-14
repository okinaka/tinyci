<?php
/**
 * TinyCI: Very small continuous integration for PHP
 * Copyright 2014, OKINAKA Kenshin <okinakak@yahoo.co.jp>
 *
 * Licensed under The MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 */

namespace TinyCI;

use Symfony\Component\Process\Process;

class Builder
{
    /**
     * @var \TinyCI\Config
     */
    private $config;

    /**
     * @var \TinyCI\Build
     */
    private $build;

    public function __construct(Config $config, Build $build)
    {
        $this->config = $config;
        $this->build = $build;
    }

    public function getBuildDir()
    {
        $dir = sprintf('/project%d-build%d', $this->build->project->id, $this->build->id);
        return $this->config->baseBuildDir . $dir;
    }

    public function createWorkingCopy()
    {
        $dir = $this->getBuildDir();
        $repo = $this->build->project->repository;
        $branch = $this->build->project->branch;
        $cmd = "git clone --progress --recursive {$repo} {$dir} --branch {$branch}";
        return $this->runProcess($cmd);
    }

    public function deleteWorkingCopy()
    {
        $dir = $this->getBuildDir();
        $cmd = sprintf('rm -rf %s', $dir);
        return $this->runProcess($cmd);
    }

    public function log($message)
    {
        echo $message, "\n";
    }

    public function execute()
    {
        // setup.

        // stage setup
        // stage test
        // stage complete
        // stage success or failuer

        // teardown.
    }

    private function runProcess($cmd)
    {
        $process = new Process($cmd);
        $process->setTimeout(3600);
        $process->run();
        return $process->isSuccessful();
    }
}
