<?php
namespace TinyCI;

/**
 * @SuppressWarnings(PHPMD.ShortVariable)
 */
class Build
{
    use ProcessTrait;

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

    public function createWorkingCopy()
    {
        $dir = $this->dir();
        $repo = $this->project->repository;
        $branch = $this->project->branch;
        $cmd = "git clone --progress --recursive {$repo} {$dir} --branch {$branch}";
        return $this->runProcess($cmd);
    }

    public function deleteWorkingCopy()
    {
        $dir = $this->dir();
        $cmd = sprintf('rm -rf %s', $dir);
        return $this->runProcess($cmd);
    }
}
