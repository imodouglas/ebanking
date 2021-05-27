<?php

$routes = [];

function route($action, $callback){
    global $routes;
    $action = trim($action, 'ebanking/');
    $routes[$action] = $callback;
}

function dispatch($action){
    global $routes;
    $action = trim($action, 'ebanking/');

    $callback = null;
    $params = [];
    foreach($routes as $route => $handler){
        if(preg_match("%^{$route}$%", $action, $matches) === 1){
            $callback = $handler;
            unset($matches[0]);
            $params = $matches;
            break;
        }
    }

    // $callback = $routes[$action];

    // return call_user_func($callback);
    return call_user_func($callback, ...$params);

}