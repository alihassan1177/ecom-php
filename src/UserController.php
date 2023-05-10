<?php

namespace App;

use App\Controller;

class UserController extends Controller{

  public function register(){
    $name =     filter_var($_POST["name"], SANITIZE_STRING) ;
    $email =    filter_var($_POST["email"], SANITIZE_STRING) ;
    $password = filter_var($_POST["password"], SANITIZE_STRING) ;
    $address =  filter_var($_POST["address"], SANITIZE_STRING) ;
    $phone =    filter_var($_POST["phone"], SANITIZE_STRING) ;
    
    if (empty($name) || empty($email) || empty($password) || empty($address) || empty($phone)) {
      $this->response("All Fields are Required", false);   
      return;
    }


  }

  public function login(){

    $email =    filter_var($_POST["email"], SANITIZE_STRING) ;
    $password = filter_var($_POST["password"], SANITIZE_STRING) ;
    
    if (empty($email) || empty($password)) {
      $this->response("All Fields are Required", false);   
      return;
    }

  }

  public function singleUser(){
  }
}

