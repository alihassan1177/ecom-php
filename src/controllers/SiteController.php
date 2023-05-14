<?php

namespace App;

use App\Controller;


class SiteController extends Controller
{
  public function index(array $params)
  {
    $settings = [];

    if (count($settings) == 0) {
      $settings["name"] = $_ENV["SITE_NAME"];
    } else {
      $settings = $settings[0];
    }

    $params["settings"] = $settings;

    $pageInfo = ["title" => "Site Settings", "description" => "Site Settings Page Admin Panel"];
    $this->renderView($pageInfo, "admin/site/index", "admin", $params);
  }
}
