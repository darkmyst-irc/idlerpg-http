<?php

function autoload($className) {
    $path = 'app';
    if (strpos($className, 'Controller') > 0) {
        $path = 'controllers';
    }
    $filename = __DIR__ . '/' . $path . '/' . str_replace('_', '/', $className) . '.php';
    if (file_exists($filename)) {
        require_once($filename);
    }
}
spl_autoload_register('autoload');

$configuration = parse_ini_file(__DIR__ . '/config.ini', true);

$botConfParser = new Parser_Botconf();
$configuration['botconf'] = $botConfParser->getBotconf(file($configuration['general']['botconf']));

View::setConfiguration($configuration);
Map::setConfiguration($configuration);

$webroot = ltrim($configuration['general']['webroot'], '/');
$url     = ltrim($_SERVER['REQUEST_URI'], '/');

$router = new Router($webroot, $url);
$router->route($configuration);
