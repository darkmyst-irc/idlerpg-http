<?php

class Router
{

    private $pathPieces = array();

    private $routes = array(
        'players' => array(
            'list' => 'listAction',
        ),
        'player' => array(
            '*' => 'characterAction',
        ),
        'index' => array(
            '*' => 'indexAction',
        ),
        'quests' => array(
            '*' => 'showAction',
        ),
        'map' => array(
            'view' => 'viewAction',
            '*' => 'renderAction',
        ),
    );

    public function __construct($webroot, $url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $path = substr($path, strlen($webroot));
        $this->pathPieces = explode('/', $path);
    }

    public function route($configuration)
    {
        $controllerSlug  = $this->getController();

        $controllerClass = ucfirst($controllerSlug) . 'Controller';
        if (!class_exists($controllerClass)) {
            return null;
        }

        $actionWithParameters = $this->getRoute(
            array_slice($this->pathPieces, 1),
            $this->routes[$controllerSlug]
        );

        $action = $actionWithParameters['action'];
        $params = array();
        if (
            array_key_exists('parameters', $actionWithParameters)
            && (!empty($actionWithParameters['parameters']))
        ) {
            $params = (array) $actionWithParameters['parameters'];
        }

        $controller = new $controllerClass($configuration);
        call_user_func_array(array($controller, $action), $params);
    }

    public function getController()
    {
        $controller = reset($this->pathPieces);
        if (empty($controller)) {
            return 'index';
        }
        return $controller;
    }

    public function getRoute(array $remainingPathPieces, $remainingRouteDefinition)
    {
        if (!is_array($remainingRouteDefinition)) {
            return array(
                'action' => $remainingRouteDefinition,
            );
        }

        $currentMatch = (string) reset($remainingPathPieces);
        if (array_key_exists($currentMatch, $remainingRouteDefinition)) {
            return $this->getRoute(
                array_slice($remainingPathPieces, 1),
                $remainingRouteDefinition[$currentMatch]
            );
        } else if (array_key_exists('*', $remainingRouteDefinition)) {
            return array_merge_recursive(
                array(
                    'parameters' => array($currentMatch,),
                ),
                $this->getRoute(
                    array_slice($remainingPathPieces, 1),
                    $remainingRouteDefinition['*']
                )
            );
        }

        return null;
    }

}