<?php 

namespace App;

use App\Controller;

class HomeController extends Controller{
    public function index()
    {
        $pageInfo = ["title"=>"Home"];
        $this->renderView($pageInfo, "client/home/index", "main");   
    }
}