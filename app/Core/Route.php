<?php
namespace App\Core;

class Route 
{
    protected static array $routes = [];

    protected static array $methods = ['GET', 'POST', 'PUT', 'DELETE'];

    protected static array $currentMiddleware = [];

    public static function get($path, $handler)
    { self::addRoute('GET', $path, $handler); }
    public static function post($path, $handler)
    { self::addRoute('POST', $path, $handler); }
    public static function put($path, $handler)
    { self::addRoute('PUT', $path, $handler); }
    public static function delete($path, $handler)
    { self::addRoute('DELETE', $path, $handler); }

    public static function middleware($middleware)
    {
        self::$currentMiddleware = is_array($middleware) ? $middleware : [$middleware];
        return new static;
    }

    protected static function addRoute(string $method, string $path, $handler)
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middleware' => self::$currentMiddleware,
        ];
        self::$currentMiddleware = [];
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    }