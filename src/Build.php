<?php
namespace TinyCI;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Build
{
    public $project;

    public $id;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function dir()
    {
        $dir = sprintf('/project%d-build%d', $this->project->id, $this->id);
        return $this->project->baseBuildDir() . $dir;
    }
}
