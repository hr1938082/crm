<?php


class Registry
{
    private $services = [];
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Self;
        }

        return self::$instance;
    }

    public function set($name, $value)
    {
        if (!in_array($name, $this->services)) {
            $this->services[$name] = $value;
        }
    }

    public function get($name)
    {
        if (array_key_exists($name, $this->services)) {
            return $this->services[$name];
        }

        return null;
    }
}
