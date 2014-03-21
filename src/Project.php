<?php
namespace TinyCI;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Project
{
    public $id;

    /**
     * @var \TinyCI\Config
     */
    public $config;

    public function baseBuildDir()
    {
        return $this->config->baseBuildDir;
    }
}
