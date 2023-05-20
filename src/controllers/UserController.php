<?php

namespace App\controllers;

use App\controllers\Controller;
use App\utils\Validator;
use App\core\Database;

class UserController extends Controller
{

  private const BCRYPT_COST_COUNT = 12;
  public function register()
  {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $countryId = $_POST["select-country"];
    $stateId = $_POST["select-state"];
    $cityId = $_POST["select-city"];

    $validate = Validator::validateInput([
      "email" => $email,
      "name" => $name,
      "password" => $password,
      "address" => $address,
      "phone" => $phone,
      "city"=>$cityId,
      "country"=>$countryId,
      "state"=>$stateId
    ]);

    if (count($validate["errors"]) > 0) {
      $this->response(json_encode($validate["errors"]), false);
      return;
    }

    if (strlen($password) < 8) {
      $this->response(json_encode(["password" => "Password should be 8 characters long"]), false);
      return;
    }

    $user = Database::getResultsByQuery("SELECT * FROM `users` WHERE `email` = '$email'");

    if (count($user) > 0) {
      $this->response(json_encode(["email" => "User Already Exists with Email : " . $email]), false);
      return;
    }

    $securedPassword = password_hash($password, PASSWORD_BCRYPT, ["cost" => self::BCRYPT_COST_COUNT]);

    $filteredName = $validate["values"]["name"];
    $filteredAddress = $validate["values"]["address"];
    $filteredPhone = $validate["values"]["phone"];

    $fullAddress = json_encode(["countryId" => $countryId, "stateId" => $stateId, "cityId" => $cityId, "address" => $filteredAddress]);

    $sql = "INSERT INTO `users`(`name`, `email`, `password`, `address`, `phone`) VALUES ('$filteredName','$email','$securedPassword','$fullAddress','$filteredPhone')";
    Database::onlyExecuteQuery($sql);

    $this->response("New User Created Successfully", true);
    return;
  }

  public function login()
  {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $validate = Validator::validateInput(["email" => $email, "password" => $password]);

    if (count($validate["errors"]) > 0) {
      $this->response(json_encode($validate["errors"]), false);
      return;
    }

    $user = Database::getResultsByQuery("SELECT * FROM `users` WHERE `email` = '$email'");

    if (count($user) <= 0) {
      $this->response("User does not exists with Email : " . $email, false);
      return;
    }

    $user = $user[0];

    if (!password_verify($password, $user["password"])) {
      $this->response("Incorrect Password", false);
      return;
    }

    $_SESSION["client"] = true;
    $_SESSION["user"] = $user;
    $this->response("User logged in Successfully", true);
    return;
  }

  public function dashboard(array $params)
  {
    $user = $_SESSION["user"];
    $userId = $user["id"];
    // $carts = Database::getResultsByQuery("SELECT * FROM `cart` WHERE `user_id` = $userId");

    // $params["carts"] = $carts;

    $pageInfo = ["title" => "Dashboard", "description" => "Dashboard Page"];
    $this->renderView($pageInfo, "client/dashboard/index", "main", $params);
  }


  public function logout()
  {
    session_destroy();
    header("location:/login");
  }
}
