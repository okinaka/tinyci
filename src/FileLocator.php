<?php
namespace TinyCI;

use Symfony\Component\Finder\Finder;

class FileLocator
{
    private $paths = [];

    public function __construct($basedir)
    {
        $paths = [$basedir, $basedir . 'vendor' . DS . 'bin'];
        $paths = array_merge($paths, explode(PATH_SEPARATOR, getenv('PATH')));
        foreach ($paths as $path) {
            if (is_dir($path)) {
                $this->paths []= $path;
            }
        }
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
