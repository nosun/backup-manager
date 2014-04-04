<?php namespace BigName\DatabaseBackup\Filesystems;

use BigName\DatabaseBackup\Config\Config;

class FilesystemProvider
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getType($name)
    {
        $class = new $this->getClassName($this->config->get($name, 'type'));
        if ( ! class_exists($class)) {
            throw new FilesystemTypeNotSupported('The requested filesystem type "' . $class . '" is not currently supported.');
        }
        return (new $class)->get($this->config->get($name));
    }

    private function getClassName($type)
    {
        return "BigName\\DatabaseBackup\\Filesystems\\{$type}Filesystem";
    }
}
