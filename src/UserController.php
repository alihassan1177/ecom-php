<?php

namespace App;

use App\Controller;
use App\Validator;

class UserController extends Controller
{

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
      $this->response(json_encode(["password"=> "Password should be 8 characters long"]), false);
      return;
    }    

    $user = Database::getResultsByQuery("SELECT * FROM `users` WHERE `email` = $email");

    if (count($user) > 0) {
      $this->response(json_encode(["email" => "User Already Exists with Email : " . $email]), false);
      return;
    }

    $sql = "";
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

    $this->response(json_encode(["email" => $email, "password" => $password]), true);
    return;
  }

  public function dashboard()
  {
  }
}
