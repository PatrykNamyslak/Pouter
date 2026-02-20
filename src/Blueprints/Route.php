<?php
namespace PatrykNamyslak\Pouter;

abstract class Route{

    public static function get(string $endpoint, array|string|null $middleware): void{
        global $app;
        $app->get('router')->addRoute(method: "get", endpoint: $endpoint, middleware: $middleware);
    }
    public static function post(string $endpoint, array|string|null $middleware): void{
        global $app;
        $app->get('router')->addRoute(method: "post", endpoint: $endpoint, middleware: $middleware);
    }
    public static function delete(string $endpoint, array|string|null $middleware): void{
        global $app;
        $app->get('router')->addRoute(method: "delete", endpoint: $endpoint, middleware: $middleware);
    }

    /**
     * The `put` method is idempotent and returns the entire modified resource or the replacement resource.
     * @return Route
     */
    public static function put(string $endpoint, array|string|null $middleware): void{
        global $app;
        $app->get('router')->addRoute(method: "put", endpoint: $endpoint, middleware: $middleware);
    }

    /**
     * The `patch` method is not idempotent and only expects what needs to be changed in the request body
     * @return Route
     */
    public static function patch(string $endpoint, array|string|null $middleware): void{
        global $app;
        $app->get('router')->addRoute(method: "patch", endpoint: $endpoint, middleware: $middleware);
    }

}