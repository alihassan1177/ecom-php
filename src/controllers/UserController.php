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

    $validate = Validator::validateInput([
      "email" => $email,
      "name" => $name,
      "password" => $password,
      "address" => $address,
      "phone" => $phone
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

    $sql = "INSERT INTO `users`(`name`, `email`, `password`, `address`, `phone`) VALUES ('$filteredName','$email','$securedPassword','$filteredAddress','$filteredPhone')";
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

    $this->response(json_encode(["email" => $email, "password" => $password]), true);
    return;
  }

  public function dashboard()
  {
  }
}
