<?php

namespace App;

use App\Controller;
use App\Database;

class TestController extends Controller
{
    public function categoryName(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
        $params["categories"] = $categories;

        $postCategories = Database::getResultsByQuery("SELECT * FROM `post_categories`");
        $params["postCategories"] = $postCategories;


        $products = Database::getResultsByQuery("SELECT * FROM `products`");
        $params["products"] = $products;


        $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "test", "test", $params);
    }
}
