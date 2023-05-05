<?php 

namespace App;

use App\Controller;
use App\Database;

class HomeController extends Controller{
    public function index(array $params)
    {
        $products = Database::getResultsByQuery("SELECT * FROM `products`");
        $banners = Database::getResultsByQuery("SELECT * FROM `banners`");
        $categories = Database::getResultsByQuery("SELECT * FROM `categories` LIMIT 6;");

        $params["banners"] = $banners;
        $params["products"] = $products;
        $params["categories"] = $categories;

        $pageInfo = ["title"=>"Home"];
        $this->renderView($pageInfo, "client/home/index", "main", $params);   
    }
}