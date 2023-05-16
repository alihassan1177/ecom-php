<?php

namespace App\controllers;

use App\controllers\Controller;

class OrderController extends Controller
{
  public function index(array $params)
  {
    //   $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
    //   $products = Database::getResultsByQuery("SELECT * FROM `products` ORDER BY `id` DESC");
    //   $params["categories"] = $categories;
    //   $params["products"] = $products;

    $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
    $this->renderView($pageInfo, "admin/orders/index", "admin", $params);
  }
}
