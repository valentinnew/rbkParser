<?php

trait SingletonTrait
{
    private static $instance;

    private function __construct()
    {
        $this->init();
    }
    private function __clone()
    {
    }

    protected function init()
    {

    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}