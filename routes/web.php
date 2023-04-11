<?php

use App\AdminController;
use App\Router;
use App\Functions;
use App\HomeController;
use App\ProductController;

$router = new Router();

if ($_SESSION["admin"] == true) {
    $router->get("/admin", [AdminController::class, "index"]);
    $router->get("/admin/logout", [AdminController::class, "logout"]);

    // Product Routes
    $router->get("/admin/products", [ProductController::class, "index"]);
    $router->get("/admin/products/new", [ProductController::class, "newProduct"]);
    $router->get("/admin/products/categories", [ProductController::class, "categories"]);
    $router->get("/admin/products/categories/new", [ProductController::class, "newCategory"]);

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
