<?php

namespace App\controllers;

use App\controllers\Controller;
use App\core\Database;

class AdminController extends Controller
{
  public function index()
  {
    $pageInfo = ["title" => "Admin Panel"];
    $this->renderView($pageInfo, "admin/home/index", "admin");
  }

  public function login()
  {
    $pageInfo = ["title" => "Admin Login"];
    $this->renderView($pageInfo, "admin/auth/login", "admin-login");
  }

  public function signIn()
  {
    $json = file_get_contents("php://input");
    $data = json_decode($json);

    if (empty($data->email) || empty($data->password)) {
      $this->response("All Fields are Required", false);
      return;
    }

    $email = $data->email;
    $password = $data->password;

    $adminData = Database::getResultsByQuery("SELECT * FROM `admin` WHERE `email` = '$email' AND `password` = '$password'");

    if (count($adminData) <= 0) {
      $this->response("User Credentials does not Matched", false);
      return;
    }

    $this->response("User Login Success", true);
    $_SESSION["admin"] = true;
    $_SESSION["admin_data"] = $adminData[0];
  }

  public function results(array $params)
  {
    $query = $_POST["query"];
    if (empty($query)) {
      header("location:/admin");
      return;
    }
    $results = $this->searchResults($query);
    $params["results"] = $results;
    $pageInfo = ["title" => "Search Results for '$query'"];
    $this->renderView($pageInfo, "admin/search", "admin", $params);
  }

  private function searchResults(string $query)
  {
    $query = htmlentities($query);

    if ($query == "products") {
      $products = Database::getResultsByQuery("SELECT * FROM `products`");
      $results = ["products" => $products];
      return $results;
    }

    if ($query == "categories") {
      $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
      $postCategories = Database::getResultsByQuery("SELECT * FROM `post_categories`");

      $results = ["categories" => $categories, "postCategories" => $postCategories];
      return $results;
    }

    if ($query == "posts") {
      $posts = Database::getResultsByQuery("SELECT * FROM `posts`");

      $results = ["posts" => $posts];

      return $results;
    }

    $products = Database::getResultsByQuery("SELECT * FROM `products` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");
    $categories = Database::getResultsByQuery("SELECT * FROM `categories` WHERE  (CONVERT(`name` USING utf8) LIKE '%$query%')");
    $postCategories = Database::getResultsByQuery("SELECT * FROM `post_categories` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");
    $posts = Database::getResultsByQuery("SELECT * FROM `posts` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");

    $results = ["products" => $products, "categories" => $categories, "postCategories" => $postCategories, "posts" => $posts];
    return $results;
  }

  public function suggestions()
  {
    $query = $_POST["query"];
    if (empty(trim($query))) {
      return;
    }
    $_SESSION["query"] = $query;

    $results = $this->searchResults($query);
    $this->response(json_encode($results), true);
    return;
  }

  public function logout()
  {
    session_destroy();
  }
}
