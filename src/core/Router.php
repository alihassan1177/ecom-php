<?php

namespace App\core;

class Router
{
    private array $handlers;
    private const METHOD_POST = "POST";
    private const METHOD_GET = "GET";
    private $notFoundCallback;

    public function run()
    {
        $requestURI = parse_url($_SERVER["REQUEST_URI"]);
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $requestPath = $requestURI["path"];

        $lastIdx = strlen($requestPath) - 1;
        if (strlen($requestPath) > 1) {
            if ($requestPath[$lastIdx] == "/") {
                $requestPath = rtrim($requestPath, "/");
                header("location:$requestPath");
            }
        }

        $callback = null;

        foreach ($this->handlers as $handler) {
            if ($requestPath === $handler["path"] && $requestMethod === $handler["method"]) {
                $callback = $handler["handler"];
            }
        }

        if (is_array($callback)) {
            $controller = new $callback[0];
            $method = $callback[1];
            $callback = [$controller, $method];
        }

        if (!$callback) {
            $callback = $this->notFoundCallback;
        }

        call_user_func_array($callback, [array_merge($_GET, $_POST)]);
    }

    public function addNotFoundCallback($handler)
    {
        $this->notFoundCallback = $handler;
    }

    private function addHandler(string $method, string $path, $handler)
    {
        $key = strtolower($method . $path);
        $this->handlers[$key] = [
            "path" => $path,
            "method" => $method,
            "handler" => $handler
        ];
    }

    public function post(string $path, $handler)
    {
        $this->addHandler(self::METHOD_POST, $path, $handler);
    }

    public function get(string $path, $handler)
    {
        $this->addHandler(self::METHOD_GET, $path, $handler);
    }
}
