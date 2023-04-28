<?php

namespace App;

use App\Controller;

class ShopController extends Controller{
    public function index()
    {
        $pageInfo = ["title" => "Shop"];
        $this->renderView($pageInfo, "client/shop/index", "main");
    }

    public function details()
    {
        $pageInfo = ["title" => "Details"];
        $this->renderView($pageInfo, "client/shop/detail", "main");
    }

}