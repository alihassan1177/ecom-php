<?php

namespace App;

use App\Controller;


class AdminController extends Controller{
    public function index()
    {
        $pageInfo = ["title"=>"Admin Panel"];
        $this->renderView($pageInfo,"admin/home/index","admin");
    }

    public function login()
    {
        $pageInfo = ["title"=>"Admin Login"];
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

    public function logout()
    {
        session_destroy();
    }
}