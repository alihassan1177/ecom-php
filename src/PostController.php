<?php

namespace App;

use App\Controller;

class PostController extends Controller{

    public function index(array $params)
    {
      $pageInfo = ["title" => "Posts", "description" => "Posts Page Admin Panel"];
      $this->renderView($pageInfo, "admin/posts/index", "admin", $params);
    }
    public function newProduct(array $params)
    {
      $pageInfo = ["title" => "New Post", "description" => "Posts Page Admin Panel"];
      $this->renderView($pageInfo, "admin/posts/new", "admin", $params);
    }
    
}