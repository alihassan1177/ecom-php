<?php

namespace App\controllers;

use App\controllers\Controller;

class ContactController extends Controller
{

    public function index()
    {
        $pageInfo = ["title" => "Contact"];
        $this->renderView($pageInfo, "client/contact/index", "main");
    }
}
