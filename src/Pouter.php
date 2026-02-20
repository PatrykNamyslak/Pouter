<?php
namespace PatrykNamyslak;
use InvalidArgumentException;
use PatrykNamyslak\Pouter\Blueprints\Http\Middleware;
use PatrykNamyslak\Pouter\Blueprints\Http\Request;
use PatrykNamyslak\Pouter\Route;

abstract class Pouter{
    /**
     * Holds all of the defined routes in routes/web.php grouped by request method
     */
    protected static array $routes = [
        "post" => [],
        "get" => [],
        "delete" => [],
        "patch" => [],
        "put" => [],
    ];

    /**
     * Handle the incoming request by running the route logic if it exists in `self::$routes`
     * @param string $method
     * @param string $uri
     * @return void
     */
    public function handleIncomingRequest(Request $request): void{
        $groupToSearch = self::$routes[$request->method];
        // Route array that contains the action and middleware
        $route = $groupToSearch[$request->endpoint] ?? null;
        if (!$route){
            http_response_code(404);
            return;
        }
        $middleware = $route["middleware"];
        foreach($middleware as $middlewareClass){
            $middlewareInstance = new $middlewareClass;
            if (!($middlewareInstance instanceof Middleware)){
                throw new InvalidArgumentException("All middlewares must implement ".Middleware::class);
            }
            if (!$middlewareInstance->handle($request)){
                $middlewareInstance->failure();
                return;
            }
        }
        // Usually a controller
        $actionClass = $route["action"]["class"];
        $actionClassInstance = new $actionClass;
        $actionClassInstance->{$route["action"]["method"]}($request);
    }

    public function addRoute(string $method, string $endpoint, array $action, array $middleware): void{
        if (count($action) > 2 || $action === []){
            throw new InvalidArgumentException('Route $action is invalid');
        }
        $newRoute = [
            "action" => [
                "class" => $action[0],
                "method" => $action[1],
            ],
            "middleware" => $middleware,
        ];
        self::$routes[$method][$endpoint] = $newRoute;
    }

}