<?php
namespace PatrykNamyslak\Pouter\Blueprints\Http;

class Request{
    /**
     * Summary of __construct
     * @param string $method
     * @param string $endpoint
     * @param array $body The request body, contains $_GET, $_POST and php://input all in one array that is captured in `Request::capture()`
     */
    public function __construct(protected(set) string $method, protected(set) string $endpoint, protected(set) array $body){}

    public static function capture(): Request{
        // Capture the request type
        $requestType = $_SERVER['REQUEST_METHOD'];
        $requestedEndpoint = $_SERVER['REQUEST_URI'];
        // Capture the request data
        $requestData = match ($requestType){
            "POST" => $_POST,
            "GET" => $_GET,
            // If its a DELETE request for example, capture everything just to be safe
            default => ["POST" => $_POST, "GET" => $_GET, "JSON" => file_get_contents("php://input")],
        };
        return new self(method: $requestType, endpoint: $requestedEndpoint, body: $requestData);
    }
}