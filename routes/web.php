<?php

use App\AdminController;
use App\Router;
use App\Functions;
use App\HomeController;

$router = new Router();

if ($_SESSION["admin"] == true) {
    $router->get("/admin", [AdminController::class, "index"]);
    $router->get("/admin/logout", [AdminController::class, "logout"]);
} else {
    $router->get("/admin", [AdminController::class, "login"]);
    $router->post("/admin/signin", [AdminController::class, "signin"]);
}

$router->get("/", [HomeController::class, "index"]);


// 404 Page
$router->addNotFoundCallback(function () {
    echo Functions::getTemplate("404");
});

$router->run();
