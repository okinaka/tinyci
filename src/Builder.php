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

    public function execute()
    {
    }
}
