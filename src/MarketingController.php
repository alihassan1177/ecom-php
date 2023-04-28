<?php

namespace App;

use App\Controller;
use App\File;

class MarketingController extends Controller
{
    public function banners(array $params)
    {
        $banners = Database::getResultsByQuery("SELECT * FROM `banners`;");
        $params["banners"] = $banners;
        $pageInfo = ["title" => "Banners"];
        $this->renderView($pageInfo, "admin/marketing/banners/index", "admin", $params);
    }

    
    public function newBanner()
    {
        $pageInfo = ["title" => "New Banner"];
        $this->renderView($pageInfo, "admin/marketing/banners/new", "admin");
    }

    public function createBanner()
    {
        $heading = $_POST["heading"];
        $subHeading = $_POST["sub-heading"];
        $btnText = $_POST["btn-text"];
        $btnLink = $_POST["btn-link"];
        $image = $_FILES["image"];

        $heading = htmlentities(trim($heading));
        $subHeading = htmlentities(trim($subHeading));
        $btnText = htmlentities(trim($btnText));
        $btnLink = htmlentities(trim($btnLink));

        if (empty($heading) || empty($subHeading) || empty($btnLink) || empty($btnText) || $image == null || count($image) <= 0) {
            $this->response("All Fields are Required", false);
            return;
        }

        $imageURL = "";
        $imageURL .= File::imageUpload($image);
        if (!$imageURL) {
            $this->response("FileType not Allowed : " . $image["type"], false);
            return;
        }

        Database::onlyExecuteQuery("INSERT INTO `banners`(`heading`, `sub_heading`, `image`, `btn_link`, `btn_text`) VALUES ('$heading','$subHeading','$imageURL','$btnLink','$btnText')");

        $this->response("Banner Created Successfully", true);
        return;
    }
}
