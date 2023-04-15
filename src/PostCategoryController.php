<?php

namespace App;

use App\Controller;

class PostCategoryController extends Controller{
    public function index(array $params)
    {
        $pageInfo = ["title" => "Product Categories", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/posts/categories/index", "admin", $params);
    }

}