<?php
namespace TinyCI;

use Symfony\Component\Yaml\Parser as YamlParser;

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

    public function getStageConfig()
    {
        $path = $this->dir() . '/phpci.yml';
        if (!is_file($path)) {
            return false;
        }
        $source = file_get_contents($path);
        return (new YamlParser())->parse($source);
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
