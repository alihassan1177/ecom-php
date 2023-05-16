<?php

namespace App\controllers;

use App\controllers\Controller;
use App\utils\File;
use App\core\Database;

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

  public function editBanner(array $params)
  {
    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $id = $_GET["id"];
      if (is_int(intval($id))) {
        $banner = Database::getResultsByQuery("SELECT * FROM `banners` WHERE `id` = $id");
        $params["banner"] = $banner[0];
        $pageInfo = ["title" => "Edit Banner"];
        $this->renderView($pageInfo, "admin/marketing/banners/edit", "admin", $params);
        return;
      }
    }

    header("location:/admin/banners");
    return;
  }

  public function singleBanner()
  {
    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $id = $_GET["id"];
      if (is_int(intval($id))) {
        $banner = Database::getResultsByQuery("SELECT * FROM `banners` WHERE `id` = $id");
        if (count($banner) > 0) {
          $params["banner"] = $banner[0];
          $pageInfo = ["title" => "", "description" => ""];
          $this->renderView($pageInfo, "admin/marketing/banners/details", "admin", $params);
          return;
        }
      }
    }

    header("location:/admin/banners");
  }

  public function deleteBanner()
  {
    if (isset($_POST["id"]) && $_POST["id"] != "") {
      $id = $_POST["id"];
      if (is_int(intval($id))) {
        $banner = Database::getResultsByQuery("SELECT * FROM `banners` WHERE `id` = $id;");
        if (count($banner) > 0) {
          $oldImagePath = __DIR__ . "/../public" . $banner["image"];
          if (file_exists($oldImagePath) && $banner["image"] != "") {
            unlink($oldImagePath);
          }
          Database::onlyExecuteQuery("DELETE FROM `banners` WHERE `id` = $id;");
          $this->response("Banner Deleted Successfully", true);
          return;
        }
      }
    }
    $this->response("Invalid Banner ID Provided", false);
    return;
  }

  public function updateBanner()
  {
    if (isset($_POST["id"]) && $_POST["id"] != "") {
      $id = $_POST["id"];
      if (is_int(intval($id))) {
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

        $banner = Database::getResultsByQuery("SELECT * FROM `banners` WHERE `id` = $id");
        if (count($banner) > 0) {
          $banner = $banner[0];
          $oldImagePath = __DIR__ . "/../public" . $banner["image"];
          if (file_exists($oldImagePath) && $banner["image"] != "") {
            unlink($oldImagePath);
          }
          // Update Query
          Database::onlyExecuteQuery("UPDATE `banners` SET `heading`='$heading',`sub_heading`='$subHeading',`image`='$imageURL',`btn_link`='$btnLink',`btn_text`='$btnText' WHERE `id` = $id;");
          $this->response("Banner updated Successfully", true);
          return;
        }
      }
    }

    $this->response("Banner ID is not Valid", false);
    return;
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
