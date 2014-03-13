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

    public function execute()
    {
    }
}
