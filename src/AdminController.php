<?php

namespace App;

use App\Controller;


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

    public function search()
    {
        $query = $_POST["query"];
        if (empty(trim($query))) {
            return;
        }

        $query = htmlentities($query);
        
        if ($query == "products") {
            $products = Database::getResultsByQuery("SELECT * FROM `products`");
            $results = ["products"=>$products];
            $this->response(json_encode($results), true);
            return;
        }
        
        if ($query == "categories") {
            $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
            $postCategories = Database::getResultsByQuery("SELECT * FROM `post_categories`");

            $results = ["categories"=>$categories, "postCategories"=>$postCategories];
            $this->response(json_encode($results), true);
            return;
        }

        $products = Database::getResultsByQuery("SELECT * FROM `ecom`.`products` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");
        $categories = Database::getResultsByQuery("SELECT * FROM `ecom`.`categories` WHERE  (CONVERT(`name` USING utf8) LIKE '%$query%')");
        $postCategories = Database::getResultsByQuery("SELECT * FROM `ecom`.`post_categories` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");
        $posts = Database::getResultsByQuery("SELECT * FROM `ecom`.`posts` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");

        $results = ["products"=>$products, "categories"=>$categories, "postCategories"=>$postCategories, "posts"=>$posts];
        $this->response(json_encode($results), true);
        return;
    }

    public function logout()
    {
        session_destroy();
    }
}
