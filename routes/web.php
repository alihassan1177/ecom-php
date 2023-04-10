<?php

use App\AdminController;
use App\Router;
use App\Functions;
use App\HomeController;

$router = new Router();

$router->get("/", [HomeController::class, "index"]);
$router->get("/admin", [AdminController::class, "index"]);
$router->get("/login", [AdminController::class, "login"]);

// 404 Page
$router->addNotFoundCallback(function () {
    echo Functions::getTemplate("404");
});

$router->run();
