<?php

namespace App\controllers;

use App\controllers\Controller;
use App\core\Database;

class OrderController extends Controller
{
  public function index(array $params)
  {
    $orders = Database::getResultsByQuery("SELECT * FROM `orders`");
    $users= Database::getResultsByQuery("SELECT `id`,`name` FROM `users`");
    $params["orders"] = $orders;
    $params["users"] = $users;

    $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
    $this->renderView($pageInfo, "admin/orders/index", "admin", $params);
  }
}
