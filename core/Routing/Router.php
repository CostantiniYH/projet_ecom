<?php
namespace Core\Routing;

class Router
{
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;

    }
    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (Route::getRoutes() as $route) {
            if ($route['method'] !== $method) continue;

            // Convertit {id} en groupe de capture regex
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); 
                $params = $matches;    

                foreach ($route['middleware'] as $middlewareName) {
                    $middlewareClass = 'App\\Middlewares\\' . ucfirst($middlewareName) . "Middleware";
                    $middleware = new $middlewareClass();
                    $middleware->handle();
                }

                $this->callHandler($route['handler'], $params);
                return;
            }
        }
        http_response_code(404);
        echo "404 - Page non trouvé";
    }

    private function callHandler($handler, $params = [])
    {
        if (is_string($handler) && str_contains($handler, '@')) {
            list($controllerPath, $method) = explode('@', $handler);
            $controllerClass = 'App\\Controllers\\' . str_replace('/', '\\', $controllerPath);
            $controllerObj = new $controllerClass($this->pdo);
            $controllerObj->$method(...$params);
        }

        if (is_callable($handler)) {
            $handler(...$params);
        }
    }
}
