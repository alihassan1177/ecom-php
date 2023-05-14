<?php

namespace App\controllers;

use App\Controller;

class ClientController extends Controller {
    public function login()
    {
        $pageInfo = ["title" => "Login"];
        $this->renderView($pageInfo, "client/auth/login", "main");
    }

    public function register()
    {
        $pageInfo = ["title" => "Register"];
        $this->renderView($pageInfo, "client/auth/register", "main");        
    }
}