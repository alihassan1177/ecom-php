<?php

namespace App;

use App\Controller;
use App\ProductCategoryController;

class ShopController extends Controller{
    public function index()
    {
        $pageInfo = ["title" => "Shop"];
        $this->renderView($pageInfo, "client/shop/index", "main");
    }

    public function details()
    {
        $pageInfo = ["title" => "Details"];
        $this->renderView($pageInfo, "client/shop/detail", "main");
    }

    public function cart()
    {
        $pageInfo = ["title" => "Cart"];
        $this->renderView($pageInfo, "client/shop/cart", "main");        
    }

    public function checkout()
    {
        $pageInfo = ["title" => "Checkout"];
        $this->renderView($pageInfo, "client/shop/checkout", "main");        
    }

    public function singleProduct(array $params)
    {
        if (isset($_GET["id"]) && $_GET["id"] != "") {
          $id = $_GET["id"];
          if (is_int(intval($id))) {
            $product = Database::getResultsByQuery("SELECT * FROM `products` WHERE `id` = $id");
            if (count($product) > 0) {
              $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
              $params["categories"] = $categories;
              $products = Database::getResultsByQuery("SELECT * FROM `products`");
              $params["related-products"] = $products;
          // Get First Element of Array
              $product = array_shift($product);
              $params["product"] = $product;
              $pageInfo = ["title" => $product["name"], "description" => $product["short_description"]];
              $this->renderView($pageInfo, "client/shop/single", "main", $params);
              return;
          }
      }
  }

  header("location:/shop");   
}

public function singleCategory(array $params)
{
    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $id = $_GET["id"];
      if (is_int(intval($id))) {
        $category = Database::getResultsByQuery("SELECT * FROM `categories` WHERE `id` = $id");
        if (count($category) > 0) {
          $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
          $params["categories"] = $categories;
          $products = Database::getResultsByQuery("SELECT * FROM `products`");
          $params["products"] = $products;

          $productsByCategory = ProductCategoryController::getProductsByCategory($products, $categories, $id);
          print_r($productsByCategory);
          $params["productsByCategory"] = $productsByCategory;
                       // Get First Element of Array

          $category = $category[0];
          $params["category"] = $category;
          $pageInfo = ["title" => $category["name"]];
          $this->renderView($pageInfo, "client/shop/category", "main", $params);
          return;
      }
  }
}

header("location:/shop");   
}

}