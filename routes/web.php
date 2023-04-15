<?php

use App\AdminController;
use App\Router;
use App\Functions;
use App\HomeController;
use App\ProductController;
use App\ProductCategoryController;
use App\PostController;
use App\PostCategoryController;

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
    $router->post("/admin/products/update", [ProductController::class, "updateProduct"]);    

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

function PostRoutes(){
    global $router;
    $router->get("/admin/posts", [PostController::class, "index"]);
    $router->get("/admin/posts/new", [PostController::class, "newProduct"]);

}

function PostCategoryRoutes()
{
    global $router;
    $router->get("/admin/posts/categories", [PostCategoryController::class, "index"]);
    $router->get("/admin/posts/categories/new", [PostCategoryController::class, "newCategory"]);
}

if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
    $router->get("/admin", [AdminController::class, "index"]);
    $router->get("/admin/logout", [AdminController::class, "logout"]);

    ProductRoutes();
    ProductCategoryRoutes();
    PostRoutes();
    PostCategoryRoutes();

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
