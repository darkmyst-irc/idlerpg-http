<?php

class View
{

    public static $configuration = array();

    private $filename = '';

    public function __construct($file)
    {
        $this->filename = __DIR__ . '/../views/' . $file . '.phtml';
        if (!is_readable($this->filename)) {
            throw new InvalidArgumentException('Cannot read view file ' . $this->filename . '.');
        }
    }

    public function render($parameters = array(), $partial = false)
    {
        if (!$partial) {
            require_once(__DIR__ . '/../views/header.phtml');
        }
        require_once($this->filename);
        if (!$partial) {
            require_once(__DIR__ . '/../views/footer.phtml');
        }
    }

    public function makeUrl($relativeUrl)
    {
        return rtrim($this->getConfigurationValue('general', 'webroot'), '/')
            . '/' . ltrim($relativeUrl, '/');
    }

    public static function setConfiguration(array $configuration)
    {
        static::$configuration = $configuration;
    }

    public static function getConfigurationValue($section, $name, $default = null)
    {
        if (!array_key_exists($section, static::$configuration)) {
            return $default;
        }
        if (!array_key_exists($name, static::$configuration[$section])) {
            return $default;
        }
        return static::$configuration[$section][$name];
    }

}
