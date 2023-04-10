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
}