<?php

namespace App;

use App\Controller;

class UserController extends Controller
{

  public function register()
  {
    $name =     filter_var($_POST["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email =    filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $address =  filter_var($_POST["address"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone =    filter_var($_POST["phone"],  FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($name) || empty($email) || empty($password) || empty($address) || empty($phone)) {
      $this->response("All Fields are Required", false);
      return;
    } 

    $user = Database::getResultsByQuery("SELECT * FROM `users` WHERE `email` = $email");  

    if(count($user) > 0){
      $this->response("User Already Exists with Email : ".$email, false); 
      return;
    }
 
    $sql = "";
    Database::onlyExecuteQuery($sql);  
  
    $this->response("New User Created Successfully", true);
    return;
  }

  public function login()
  {

    $email =    filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($email) || empty($password)) {
      $this->response("All Fields are Required", false);
      return;
    }

    $sql = "";
    $user = Database::getResultsByQuery($sql); 

    if(count($user) > 0){
      $this->response("User Logged In Succesfully", true);
      return;
    }

    $this->response("User Credentials not Matched", false);
    return;
  }

  public function singleUser()
  {
  }
}
