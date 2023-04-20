<?php

namespace App;

use App\Controller;

class CustomerController extends Controller{
    public function index(array $params)
    {
    //   $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
    //   $products = Database::getResultsByQuery("SELECT * FROM `products` ORDER BY `id` DESC");
    //   $params["categories"] = $categories;
    //   $params["products"] = $products;
  
      $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
      $this->renderView($pageInfo, "admin/customers/index", "admin", $params);
    }
  
}