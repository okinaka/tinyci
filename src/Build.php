<?php
namespace TinyCI;

class Build
{
    public $project;
    public $id;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}
