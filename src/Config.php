<?php
require_once __DIR__  . '/SingletonTrait.php';

class Config
{
    use SingletonTrait;

    private $_config;

    protected function init()
    {
        $this->_config = include(__DIR__ . '/../config.php');
    }

    public function __get($name)
    {
        return $this->_config[$name] ?? null;
    }
}