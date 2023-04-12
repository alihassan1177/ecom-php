<?php 

namespace App;

use App\Controller;
use App\Database;

class HomeController extends Controller{
    public function index(array $params)
    {
        $products = Database::getResultsByQuery("SELECT * FROM `products`");
        $params["products"] = $products;
        $pageInfo = ["title"=>"Home"];
        $this->renderView($pageInfo, "client/home/index", "main", $params);   
    }
}