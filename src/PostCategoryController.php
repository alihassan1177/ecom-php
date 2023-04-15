<?php

namespace App;

use App\Controller;

class PostCategoryController extends Controller{
    public function index(array $params)
    {
        $pageInfo = ["title" => "Post Categories", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/posts/categories/index", "admin", $params);
    }

    public function newCategory(array $params)
    {
        $pageInfo = ["title" => "New Post Category", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/posts/categories/new", "admin", $params);
    }

}