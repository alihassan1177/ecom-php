<?php

use App\AdminController;
use App\Router;
use App\Functions;
use App\HomeController;
use App\ProductController;
use App\ProductCategoryController;


$router = new Router();

function ProductRoutes(){
    // Product Routes
    global $router;
    $router->get("/admin/products", [ProductController::class, "index"]);
    $router->get("/admin/products/details", [ProductController::class, "singleProduct"]);
    $router->get("/admin/products/new", [ProductController::class, "newProduct"]);
    $router->post("/admin/products/create", [ProductController::class, "createProduct"]);
    $router->post("/admin/products/delete", [ProductController::class, "deleteProduct"]);    
    $router->get("/admin/products/edit", [ProductController::class, "editProduct"]);    

}

function ProductCategoryRoutes(){
    global $router;
    // Product Category Routes
    $router->get("/admin/products/categories", [ProductCategoryController::class, "categories"]);
    $router->get("/admin/products/categories/details", [ProductCategoryController::class, "singleCategory"]);
    $router->get("/admin/products/categories/new", [ProductCategoryController::class, "newCategory"]);
    $router->get("/admin/products/categories/edit", [ProductCategoryController::class, "editCategory"]);
    $router->post("/admin/products/categories/update", [ProductCategoryController::class, "updateCategory"]);
    $router->post("/admin/products/categories/create", [ProductCategoryController::class, "createCategory"]);
    $router->post("/admin/products/categories/delete", [ProductCategoryController::class, "deleteCategory"]);
}

if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
    $router->get("/admin", [AdminController::class, "index"]);
    $router->get("/admin/logout", [AdminController::class, "logout"]);

    ProductRoutes();
    ProductCategoryRoutes();
    

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
