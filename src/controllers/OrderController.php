<?php

namespace App\controllers;

use App\controllers\Controller;
use App\core\Database;
use App\enums\OrderStatus;
use App\enums\PaymentTypes;
use App\utils\Validator;


class OrderController extends Controller
{
  public function index(array $params)
  {
    $orders = Database::getResultsByQuery("SELECT * FROM `orders`");
    $users = Database::getResultsByQuery("SELECT `id`,`name` FROM `users`");
    $params["orders"] = $orders;
    $params["users"] = $users;

    $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
    $this->renderView($pageInfo, "admin/orders/index", "admin", $params);
  }

  public function createOrder()
  {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $zipCode = $_POST["zip"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $countryId = $_POST["select-country"];
    $stateId = $_POST["select-state"];
    $cityId = $_POST["select-city"];
    $items = $_POST["items"];
    $amount = $_POST["amount"];
    $payment = $_POST["payment"];

    $cart = json_decode($items);
    if ($cart == false) {
      $this->response(json_encode(["cart" => "Cart is Empty"]), false);
      return;
    }

    $validate = Validator::validateInput([
      "email" => $email,
      "name" => $name,
      "zip" => $zipCode,
      "address" => $address,
      "phone" => $phone,
      "city" => $cityId,
      "country" => $countryId,
      "state" => $stateId,
      "amount" => $amount
    ]);

    if (count($validate["errors"]) > 0) {
      $this->response(json_encode($validate["errors"]), false);
      return;
    }

    if (isset($_SESSION["client"])) {
      if ($email != $_SESSION["user"]["email"]) {
        $this->response(json_encode(["email" => "Unauthorized Email Provided"]), false);
        return;
      }

      if ($phone != $_SESSION["user"]["phone"]) {
        $this->response(json_encode(["phone" => "Unauthorized Phone Number Provided"]), false);
        return;
      }
    }

    $filteredAddress = $validate["values"]["address"];

    $fullAddress = json_encode(["countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "address" => $filteredAddress, "zipCode" => $zipCode]);

    $userId = isset($_SESSION["user"]) ? $_SESSION["user"]["id"] : null;
    $status = OrderStatus::PENDING;
    $sql = "INSERT INTO `orders`(`user_id`, `amount`, `status`, `items`, `payment_type`, `address`) VALUES ('$userId','$amount','$status','$items','$payment','$fullAddress')";
    Database::onlyExecuteQuery($sql);

    if ($userId != null) {
      $sql = "UPDATE `cart` SET `checkout`='true' WHERE `user_id` == $userId";
      Database::onlyExecuteQuery($sql);
    }
    $this->response("Order Created Successfully", true);
    return;
  }
}
