<?php

namespace App;

use App\Controller;

class ProductController extends Controller{
    public function index()
    {
        $pageInfo = ["title"=>"Products","description"=>"Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/index", "admin");
    }

    public function categories(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
        $params["categories"] = $categories;
        $pageInfo = ["title"=>"Product Categories","description"=>"Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/categories/index", "admin", $params);   
    }

    public function newProduct()
    {
        $pageInfo = ["title"=>"New Product","description"=>"Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/new", "admin");
    }
    
    public function newCategory()
    {
        $pageInfo = ["title"=>"New Product Category","description"=>"Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/categories/new", "admin");        
    }

    public function createCategory()
    {
        $categoryName = $_POST["name"];
        $categoryParent = $_POST["parent"];
        $categoryImage = $_FILES["image"];
        
        if ($categoryName == "") {
            $this->response("Category Name is Required", false);
            return;
        }

        if (!empty($categoryImage)) {

        }
    }
}