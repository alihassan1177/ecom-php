<?php

namespace App;

use App\Controller;


class SiteController extends Controller{
    public function index(array $params)
    {
    //   $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
    //   $products = Database::getResultsByQuery("SELECT * FROM `products` ORDER BY `id` DESC");
    //   $params["categories"] = $categories;
    //   $params["products"] = $products;
  
      $pageInfo = ["title" => "Site Settings", "description" => "Site Settings Page Admin Panel"];
      $this->renderView($pageInfo, "admin/site/index", "admin", $params);
    }
  
}