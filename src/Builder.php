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

use Psr\Log\LoggerAwareTrait;

class Builder
{
    use LoggerAwareTrait;

    /**
     * @var \TinyCI\Build
     */
    private $build;

    public function __construct(Build $build)
    {
        $this->build = $build;
    }

    public function executeStage($stage, $config)
    {
        if (!isset($config[$stage])) {
            return true;
        }
        $this->logger->info("START: {$stage}");

        foreach ($config[$stage] as $task => $option) {
            $result = $this->executeTask($task, $option);
            if ($result === false) {
                $this->logger->err("FAILUER: {$task}");
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

    /**
     * Convert snake_case_string to CamelCaseString.
     * @param string
     * @return string
     */
    public function toCamelCase($name)
    {
        return str_replace(' ', '', ucwords(strtr($name, '_', ' ')));
    }

    public function execute()
    {
        // before setup.
        $this->logger->info('START: before setup');
        $result = $this->build->createWorkingCopy();
        if (!$result) {
            $this->logger->err('FAILURE: create working copy.');
        }

        // load config
        $stageConfig = $this->build->getStageConfig();
        $result &= is_array($stageConfig);
        if (!$result) {
            $this->logger->err('FAILURE: load config.');
        }

        // setup
        $result &= $this->executeStage('setup', $stageConfig);

        // test
        $result &= $this->executeStage('test', $stageConfig);

        // complete
        $result &= $this->executeStage('complete', $stageConfig);

        // success or failuer
        $stage = $result ? 'success' : 'failure';
        $result &= $this->executeStage($stage, $stageConfig);

        // teardown.
        $result &= $this->build->deleteWorkingCopy();

        return (bool)$result;
    }
}
