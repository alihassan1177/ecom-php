<?php

use App\Router;
use App\AdminController;
use App\CustomerController;
use App\Functions;
use App\HomeController;
use App\OrderController;
use App\ProductController;
use App\ProductCategoryController;
use App\PostController;
use App\PostCategoryController;
use App\ShopController;
use App\SiteController;
use App\TestController;

$router = new Router();

function ProductRoutes()
{
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

function ProductCategoryRoutes()
{
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

function PostRoutes()
{
    global $router;
    $router->get("/admin/posts", [PostController::class, "index"]);
    $router->get("/admin/posts/new", [PostController::class, "newPost"]);
    $router->post("/admin/posts/create", [PostController::class, "createPost"]);
    $router->get("/admin/posts/details", [PostController::class, "singlePost"]);
    $router->post("/admin/posts/delete", [PostController::class, "deletePost"]);
    $router->get("/admin/posts/edit", [PostController::class, "editPost"]);
    $router->post("/admin/posts/update", [PostController::class, "updatePost"]);
}

function PostCategoryRoutes()
{
    global $router;
    $router->get("/admin/posts/categories", [PostCategoryController::class, "index"]);
    $router->get("/admin/posts/categories/new", [PostCategoryController::class, "newCategory"]);
    $router->post("/admin/posts/categories/create", [PostCategoryController::class, "createCategory"]);
    $router->get("/admin/posts/categories/details", [PostCategoryController::class, "singleCategory"]);
    $router->post("/admin/posts/categories/delete", [PostCategoryController::class, "deleteCategory"]);
    $router->get("/admin/posts/categories/edit", [PostCategoryController::class, "editCategory"]);
    $router->post("/admin/posts/categories/update", [PostCategoryController::class, "updateCategory"]);
}

function SiteSettingsRoutes()
{
    global $router;
    $router->get("/admin/site_settings", [SiteController::class, "index"]);
}

function OrdersRoutes()
{
    global $router;
    $router->get("/admin/orders", [OrderController::class, "index"]);
}

function CustomerRoutes()
{
    global $router;
    $router->get("/admin/customers", [CustomerController::class, "index"]);
}

if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {

    $router->get("/admin", [AdminController::class, "index"]);
    $router->get("/admin/logout", [AdminController::class, "logout"]);
    $router->post("/admin/search", [AdminController::class, "suggestions"]);
    $router->post("/admin/results", [AdminController::class, "results"]);

    ProductRoutes();
    ProductCategoryRoutes();
    PostRoutes();
    PostCategoryRoutes();
    SiteSettingsRoutes();
    CustomerRoutes();
    OrdersRoutes();

    $router->get("/test", [TestController::class, "categoryName"]);
} else {
    $router->get("/admin", [AdminController::class, "login"]);
    $router->post("/admin/signin", [AdminController::class, "signin"]);
}

$router->get("/", [HomeController::class, "index"]);
$router->get("/shop", [ShopController::class, "index"]);
$router->get("/shop/details", [ShopController::class, "details"]);

// 404 Page
$router->addNotFoundCallback(function () {
    echo Functions::getTemplate("404");
});

$router->run();
