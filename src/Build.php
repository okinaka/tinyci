<?php
namespace TinyCI;

class Build
{
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}
