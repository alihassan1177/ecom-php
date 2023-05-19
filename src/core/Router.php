<?php

namespace App\core;

class Router
{
  private array $handlers;
  private const METHOD_POST = "POST";
  private const METHOD_GET = "GET";
  private $notFoundCallback;

  private array $routeParams;

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


    if (!$callback) {

      $callback = $this->getCallback($requestPath);

      if (!$callback) {
        $callback = $this->notFoundCallback;
      }
    }

    if (is_array($callback)) {
      $controller = new $callback[0];
      $method = $callback[1];
      $callback = [$controller, $method];
    }

    call_user_func_array($callback, [array_merge($_GET, $_POST, $this->routeParams)]);
  }

  public function getCallback($url)
  {
    $url = trim($url, '/');
    $getRoutes = [];
    foreach ($this->handlers as $handler) {


      if ($handler["method"] == self::METHOD_GET) {
        $getRoutes[] = $handler;
      }
    }

    $routeParams = false;

    foreach ($getRoutes as $route) {
      $routePath = $route["path"];
      // Trim slashes
      $routePath = trim($routePath, '/');
      $routeNames = [];

      if (!$routePath) {
        continue;
      }

      if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $routePath, $matches)) {
        $routeNames = $matches[1];
      }

      $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn ($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $routePath) . "$@";

      if (preg_match_all($routeRegex, $url, $valueMatches)) {
        $values = [];
        $totalMatches = count($valueMatches);

        for ($i = 1; $i < $totalMatches; $i++) {
          $values[] = $valueMatches[$i][0];
        }

        $routeParams = array_combine($routeNames, $values);
        $this->routeParams = $routeParams;
        return $route["handler"];
      }
    }
    return false;
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
