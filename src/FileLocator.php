<?php
namespace TinyCI;

use Symfony\Component\Finder\Finder;

class FileLocator
{
    public function __construct($basedir)
    {
        $paths = [$basedir, $basedir . '/vendor/bin'];
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $this->paths []= $path;
            }
        }
        $this->paths = array_merge(explode(':', getenv('PATH')), $this->paths);
    }

    public function locate($names)
    {
        if (is_string($names)) {
            $names = [$names];
        }

        $finder = new Finder();
        $finder->files()->depth(0)->in($this->paths);
        foreach ($names as $name) {
            $finder->name($name);
        }
        foreach ($finder as $file) {
            return $file->getPathName();
        }
        return null;
    }
}