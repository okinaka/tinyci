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

use Symfony\Component\Yaml\Parser as YamlParser;

class Builder
{
    use ProcessTrait;

    /**
     * @var \TinyCI\Build
     */
    private $build;

    public function __construct(Build $build)
    {
        $this->build = $build;
    }

    public function createWorkingCopy()
    {
        $dir = $this->build->dir();
        $repo = $this->build->project->repository;
        $branch = $this->build->project->branch;
        $cmd = "git clone --progress --recursive {$repo} {$dir} --branch {$branch}";
        return $this->runProcess($cmd);
    }

    public function deleteWorkingCopy()
    {
        $dir = $this->build->dir();
        $cmd = sprintf('rm -rf %s', $dir);
        return $this->runProcess($cmd);
    }

    public function getStageConfig()
    {
        $path = $this->build->dir() . '/phpci.yml';
        if (!is_file($path)) {
            // BuildException()
        }
        $source = file_get_contents($path);
        return (new YamlParser())->parse($source);
    }

    public function executeStage($stage, $config)
    {
        if (!isset($config[$stage])) {
            return true;
        }
        foreach ($config[$stage] as $task => $option) {
            $result = $this->executeTask($task, $option);
            if ($result === false) {
                return false;
            }
        }
        return true;
    }

    public function executeTask($task, $option)
    {
        $class = 'TinyCI\\Task\\' . ucwords($task);
        if (!class_exists($class)) {
            return false;
        }
        $obj = new $class($this->build, $option);
        return $obj->execute();
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
}
