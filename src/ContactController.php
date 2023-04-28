<?php

namespace App;

use App\Controller;

class ContactController extends Controller {

    public function index()
    {
        $pageInfo = ["title" => "Contact"];
        $this->renderView($pageInfo, "client/contact/index", "main");
    }

}