<?php

namespace App\Helpers;

class Route
{
    private static $routes = array();
    private $method;
    private $path;
    private $action;

    public function __construct($method, $path, $action)
    {
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
    }

    public static function get($path, $action)
    {
        self::$routes[] = new Route('GET', $path, $action);
    }

    public static function post($path, $action)
    {
        self::$routes[] = new Route('POST', $path, $action);
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function handle($path)
    {
        echo('path:'.$path);
        $desired_route = null;

        foreach (self::$routes as $route) {
            $pattern = $route->path;
            $pattern = str_replace('/', '\/', $pattern);

            $pattern = '/^' . $pattern . '$/i';
            $pattern = preg_replace('/{[A-Za-z0-9]+}/', '([A-Za-z0-9]+)', $pattern);

            if (preg_match($pattern, $path, $match)) {
                $desired_route = $route;
                break;
            }
        }

        if ($desired_route) {
            $url_parts = explode('/', $path);
            $route_parts = explode('/', $desired_route->path);

            foreach ($route_parts as $key => $value) {
                if (!empty($value)) {
                    $value = str_replace('{', '', $value);
                    $value = str_replace('}', '', $value);

                    if (strpos($value, ':') !== false) {
                        $param_name = substr($value, 1);
                        Params::set($param_name, $url_parts[$key]);
                    }
                }
            }

            if ($desired_route->method !== $_SERVER['REQUEST_METHOD']) {
                http_response_code(405);
                echo '<h1>Method Not Allowed</h1>';
                die();
            } else {
                $actions = explode('@', $desired_route->action);
                $class = '\\App\\Controllers\\' . $actions[0];
                $obj = new $class();
                echo call_user_func([$obj, $actions[1]]);
            }
        } else {
            http_response_code(404);
            echo '<h1>404 - Not Found</h1>';
            die();
        }
    }
}
