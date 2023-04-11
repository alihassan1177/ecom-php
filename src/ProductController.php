<?php

namespace App;

use App\Controller;

class ProductController extends Controller{
    public function index()
    {
        $pageInfo = ["title"=>"Products","description"=>"Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/index", "admin");
    }
}