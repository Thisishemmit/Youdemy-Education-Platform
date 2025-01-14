<?php
namespace Core;
class Router
{
    private array $routes = [];

    public function add($method, $uri, $action): void
    {
        $this->routes[strtoupper($method)][$uri] = $action;
    }

    public function dispatch($uri, $method)
    {
        $uri = parse_url($uri)['path'];
        $method = strtoupper($method);

        foreach ($this->routes[$method] as $route => $action) {
            $route = $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)}/', '([^/]+)', $route);
            if (preg_match('#^' . $route . '$#', $uri, $matches)) {
                array_shift($matches);

                if(is_array($action)) {
                    $controller = new $action[0];
                    $method = $action[1];
                    return call_user_func_array([$controller, $method], $matches);
                }
                return call_user_func_array($action, $matches);
            }
        }

        header("HTTP/1.0 404 Not Found");
        echo "404 - Page not found";
        exit;
    }
}
