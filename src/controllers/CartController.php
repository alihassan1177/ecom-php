<?php

namespace App\controllers;

use App\controllers\Controller;
use App\core\Database;


class CartController extends Controller
{
  public function saveCart()
  {
    $this->response("CREATE USER LOGIN", false);
    return;
    if (isset($_SESSION["client"]) && $_SESSION["client"] == true) {
      $cart = $_POST["cart"];
      $checkout  = false;
      $userID = $_SESSION["clientID"];

      $sql = "INSERT INTO `cart`(`cart`, `checkout`, `user_id`) VALUES ('$cart','$checkout','$userID')";

      $result = Database::onlyExecuteQuery($sql);

      if ($result != false) {
       $this->response("Cart Saved Successfully", true); 
        return;     
      }   
      $this->response("User cart not Saved", false);
      return;
    }
    $this->response("User not Authenticated", false);
    return;
  }

  public function getCart()
  {
    $this->response("CREATE USER LOGIN", false);
    return;
    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $id = $_GET["id"];
      if (is_int(intval($id))) {
        $cart = Database::getResultsByQuery("SELECT * FROM `cart` WHERE `id` = $id");
        if (count($cart) > 0) {
          $cart = $cart[0];
          $this->response(json_encode($cart), true);
          return;
        }
      }
    }

    $this->response("Invalid User ID Provided", false);
    return;
  }
}
