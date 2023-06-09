<?php

use App\core\Router;
use App\controllers\AdminController;
use App\controllers\api\CountryController;
use App\controllers\CartController;
use App\controllers\CustomerController;
use App\utils\Functions;
use App\controllers\HomeController;
use App\controllers\OrderController;
use App\controllers\ProductController;
use App\controllers\ProductCategoryController;
use App\controllers\PostController;
use App\controllers\PostCategoryController;
use App\controllers\ShopController;
use App\controllers\SiteController;
use App\controllers\TestController;
use App\controllers\ContactController;
use App\controllers\ClientController;
use App\controllers\MarketingController;
use App\controllers\UserController;

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

function MarketingRoutes()
{
    global $router;
    $router->get("/admin/banners", [MarketingController::class, "banners"]);
    $router->get("/admin/banners/new", [MarketingController::class, "newBanner"]);
    $router->post("/admin/banners/create", [MarketingController::class, "createBanner"]);
    $router->get("/admin/banners/edit", [MarketingController::class, "editBanner"]);
    $router->get("/admin/banners/details", [MarketingController::class, "singleBanner"]);
    $router->get("/admin/banners/edit", [MarketingController::class, "editBanner"]);
    $router->post("/admin/banners/delete", [MarketingController::class, "deleteBanner"]);
    $router->post("/admin/banners/update", [MarketingController::class, "updateBanner"]);
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
    MarketingRoutes();

    $router->get("/test", [TestController::class, "categoryName"]);
} else {
    $router->get("/admin", [AdminController::class, "login"]);
    $router->post("/admin/signin", [AdminController::class, "signin"]);
}

// Client Routes
$router->get("/", [HomeController::class, "index"]);
$router->get("/shop", [ShopController::class, "index"]);
$router->get("/shop/{slug}", [ShopController::class, "singleProduct"]);
$router->get("/shop/category", [ShopController::class, "singleCategory"]);


$router->get("/contact", [ContactController::class, "index"]);
$router->get("/cart", [ShopController::class, "cart"]);
$router->get("/checkout", [ShopController::class, "checkout"]);

$router->post("/order", [OrderController::class, "createOrder"]);

$router->post("/saveCart", [CartController::class, "saveCart"]);
$router->get("/countries", [CountryController::class, "getCountries"]);
$router->get("/states", [CountryController::class, "getStates"]);
$router->get("/cities", [CountryController::class, "getCities"]);


if (isset($_SESSION["client"]) && $_SESSION["client"] == true) {
    $router->get("/getCart", [CartController::class, "getCart"]);
    $router->get("/dashboard", [UserController::class, "dashboard"]);
    $router->get("/logout", [UserController::class, "logout"]);
} else {
    $router->get("/login", [ClientController::class, "login"]);
    $router->get("/register", [ClientController::class, "register"]);

    $router->post("/user/login", [UserController::class, "login"]);
    $router->post("/user/register", [UserController::class, "register"]);
}
// 404 Page
$router->addNotFoundCallback(function () {
    echo Functions::getTemplate("404");
});

// Implementing Path Params
$router->get("/url/{id:\d+}", [TestController::class, "pathParams"]);
$router->get("/profile/{id:\d+}/{username}", [TestController::class, "pathParams"]);

$router->run();
