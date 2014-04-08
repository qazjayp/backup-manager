<?php namespace BigName\DatabaseBackup\Databases;

use BigName\DatabaseBackup\Config\Config;

class DatabaseProvider
{
    /**
     * @var \BigName\DatabaseBackup\Config\Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function get($name)
    {
        $class = $this->getClass($this->config->get($name, 'type'));
        if ( ! class_exists($class)) {
            throw new DatabaseTypeNotSupported('The requested database type "' . $class . '" is not currently supported.');
        }
        return new $class($this->config->get($name));
    }

    private function getClass($type)
    {
        $type = ucfirst(strtolower($type));
        return "BigName\\DatabaseBackup\\Databases\\{$type}Database";
    }

} 