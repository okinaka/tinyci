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

class Builder
{
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
        return $this->build->createWorkingCopy();
    }

    public function deleteWorkingCopy()
    {
        return $this->build->deleteWorkingCopy();
    }

    public function getStageConfig()
    {
        return $this->build->getStageConfig();
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
        $class = 'TinyCI\\Task\\' . $this->toCamelCase($task);
        if (!class_exists($class)) {
            return false;
        }
        $obj = new $class($this->build, $option);
        return $obj->execute();
    }

    public function toCamelCase($name)
    {
        return str_replace(' ', '', ucwords(strtr($name, '_', ' ')));
    }

    public function log($message)
    {
        echo $message, "\n";
    }

    public function execute()
    {
        // setup.
        $result = $this->build->createWorkingCopy();

        // load stage config
        $stageConfig = $this->build->getStageConfig();
        $result &= is_array($stageConfig);

        // stage setup
        $result &= $this->executeStage('setup', $stageConfig);

        // stage test
        $result &= $this->executeStage('test', $stageConfig);

        // stage complete
        $result &= $this->executeStage('complete', $stageConfig);

        // stage success or failuer
        $stage = $result ? 'success' : 'failuer';
        $result &= $this->executeStage($stage, $stageConfig);

        // teardown.
        $result &= $this->build->deleteWorkingCopy();

        return (bool)$result;
    }
}
