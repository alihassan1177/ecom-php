<?php

namespace App\controllers;

use App\controllers\Controller;
use App\core\Database;

class HomeController extends Controller
{
    public function index(array $params)
    {
        $products = Database::getInstance()->getResultsByQuery("SELECT * FROM `products` LIMIT 8");
        $banners = Database::getInstance()->getResultsByQuery("SELECT * FROM `banners`");
        $categories = Database::getInstance()->getResultsByQuery("SELECT * FROM `categories` LIMIT 6;");

        $params["banners"] = $banners;
        $params["products"] = $products;
        $params["categories"] = $categories;

        $pageInfo = ["title" => "Home"];
        $this->renderView($pageInfo, "client/home/index", "main", $params);
    }
}
