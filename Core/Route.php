<?php

namespace Core;
class Route
{
    private static $router;


    public static function get($uri, $action): void
    {
        self::addRoute('GET', $uri, $action);
    }

    public static  function post($uri, $action): void
    {
        self::addRoute('POST', $uri, $action);
    }
    private static function addRoute($method, $uri, $action): void
    {
        if(!self::$router) {
            echo 'Router not set';
            return;
        }
        self::$router->add($method, $uri, $action);
    }

    public static function dispatch($uri, $method): void
    {
        self::$router->dispatch($uri, $method);
    }

    public static function setRouter($router): void
    {
        self::$router = $router;
    }
}