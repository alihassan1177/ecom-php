<?php

namespace App\controllers;

use App\controllers\Controller;
use App\core\Database;
use App\utils\File;

class ProductController extends Controller
{
  public function index(array $params)
  {
    $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
    $products = Database::getResultsByQuery("SELECT * FROM `products` ORDER BY `id` DESC");
    $params["categories"] = $categories;
    $params["products"] = $products;

    $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
    $this->renderView($pageInfo, "admin/products/index", "admin", $params);
  }

  public function singleProduct(array $params)
  {
    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $id = $_GET["id"];
      if (is_int(intval($id))) {
        $product = Database::getResultsByQuery("SELECT * FROM `products` WHERE `id` = $id");
        if (count($product) > 0) {
          $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
          $params["categories"] = $categories;
          // Get First Element of Array
          $product = array_shift($product);
          $params["product"] = $product;
          $pageInfo = ["title" => $product["name"], "description" => $product["short_description"]];
          $this->renderView($pageInfo, "admin/products/single", "admin", $params);
          return;
        }
      }
    }

    header("location:/admin/products");
  }

  public function newProduct(array $params)
  {
    $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
    $params["categories"] = $categories;
    $pageInfo = ["title" => "New Product", "description" => "Products Page Admin Panel"];
    $this->renderView($pageInfo, "admin/products/new", "admin", $params);
  }


  private function validateCategory(int $categoryID)
  {
    if (empty($categoryID)) {
      $categoryID = 0;
    } elseif ($categoryID !== 0) {
      $availableCategories = Database::getResultsByQuery("SELECT * FROM `categories` WHERE `id` = $categoryID;");
      if (count($availableCategories) == 0) {
        $this->response("Selected Category not Available : " . $categoryID, false);
        return;
      }
    }
  }

  public function createProduct()
  {
    $productImage = isset($_FILES["image"]) ? $_FILES["image"] : null;
    $productCategory = isset($_POST["category_id"]) ? $_POST["category_id"] : null;
    $productName = isset($_POST["name"]) ? $_POST["name"] : null;
    $productQuantity = isset($_POST["quantity"]) ? $_POST["quantity"] : null;
    $productShortDescription = isset($_POST["short_description"]) ? htmlentities($_POST["short_description"]) : null;
    $productDescription = isset($_POST["description"]) ? htmlentities($_POST["description"]) : null;
    $productPrice = isset($_POST["price"]) ? $_POST["price"] : null;

    $this->validateCategory($productCategory);

    if (empty($productName)) {
      $this->response("Product Name is Required", false);
      return;
    }

    $imageURL = "";
    if (!empty($productImage)) {
      $imageURL .= File::imageUpload($productImage);
      if (!$imageURL) {
        $this->response("FileType not Allowed : " . $productImage["type"], false);
        return;
      }
    }

    $queryParams = [
      "name" => $productName,
      "image" => $imageURL,
      "short_description" => $productShortDescription,
      "description" => $productDescription,
      "category_id" => $productCategory,
      "quantity" => $productQuantity,
      "price" => $productPrice
    ];

    $this->insertData($queryParams, "products");

    $this->response("New Product Created Succesfully", true);
  }

  private function insertData(array $queryParams, string $table)
  {
    $tableColumnNames = "";
    $values = "";
    foreach ($queryParams as $key => $value) {
      if ($value != null) {
        $tableColumnNames .= "`$key`,";
        if (is_string($value)) {
          $values .= "'$value',";
        } else {
          $values .= "$value,";
        }
      }
    }

    $tableColumnNames = rtrim($tableColumnNames, ",");
    $values = rtrim($values, ",");

    $sql = sprintf("INSERT INTO `%s`(%s) VALUES (%s);", $table, $tableColumnNames, $values);
    Database::onlyExecuteQuery($sql);
  }

  public function deleteProduct()
  {
    if (isset($_POST["id"]) && $_POST["id"] != "") {
      $id = $_POST["id"];
      if (is_int(intval($id))) {
        $product = Database::getResultsByQuery("SELECT * FROM `products` WHERE `id` = $id;");
        $product = $product[0];
        if (count($product) > 0) {
          $oldImagePath = __DIR__ . "/../public" . $product["image"];
          if (file_exists($oldImagePath) && $product["image"] != "") {
            unlink($oldImagePath);
          }
          Database::onlyExecuteQuery("DELETE FROM `products` WHERE `id` = $id;");
          $this->response("Product Deleted Successfully", true);
          return;
        }
      }
    }
    $this->response("Invalid Product ID Provided", false);
    return;
  }

  public function editProduct(array $params)
  {
    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $id = $_GET["id"];
      if (is_int(intval($id))) {
        $product = Database::getResultsByQuery("SELECT * FROM `products` WHERE `id` = $id");
        $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
        $params["product"] = $product;
        $params["categories"] = $categories;
        $pageInfo = ["title" => "Edit Category"];
        $this->renderView($pageInfo, "admin/products/edit", "admin", $params);
        return;
      }
    }

    header("location:/admin/products");
    return;
  }


  private function updateData(array $queryParams, string $table, int $id)
  {
    $pairs = "";
    foreach ($queryParams as $key => $value) {
      if ($value != null) {
        if (is_string($value)) {
          $pairs .= "`$key`='$value',";
        } else {
          $pairs .= "`$key`=$value,";
        }
      }
    }

    $pairs = rtrim($pairs, ",");

    $sql = sprintf("UPDATE `%s` SET %s WHERE `id` = $id;", $table, $pairs);
    Database::onlyExecuteQuery($sql);
  }

  public function updateProduct()
  {
    if (isset($_POST["id"]) && $_POST["id"] != "") {
      $id = $_POST["id"];
      if (is_int(intval($id))) {

        $productImage = isset($_FILES["image"]) ? $_FILES["image"] : null;
        $productCategory = isset($_POST["category_id"]) ? $_POST["category_id"] : null;
        $productName = isset($_POST["name"]) ? $_POST["name"] : null;
        $productQuantity = isset($_POST["quantity"]) ? $_POST["quantity"] : null;
        $productShortDescription = isset($_POST["short_description"]) ? htmlentities($_POST["short_description"]) : null;
        $productDescription = isset($_POST["description"]) ? htmlentities($_POST["description"]) : null;
        $productPrice = isset($_POST["price"]) ? $_POST["price"] : null;

        $this->validateCategory($productCategory);

        if (empty($productName)) {
          $this->response("Product Name is Required", false);
          return;
        }

        $product = Database::getResultsByQuery("SELECT * FROM `products` WHERE `id` = $id");
        $product  = $product[0];
        $imageURL = "";
        if (!empty($productImage)) {
          unlink(__DIR__ . "/../public" . $product["image"]);
          $imageURL .= File::imageUpload($productImage);
          if (!$imageURL) {
            $this->response("FileType not Allowed : " . $productImage["type"], false);
            return;
          }
        }

        $queryParams = [
          "name" => $productName,
          "image" => $imageURL,
          "short_description" => $productShortDescription,
          "description" => $productDescription,
          "category_id" => $productCategory,
          "quantity" => $productQuantity,
          "price" => $productPrice
        ];

        $this->updateData($queryParams, "products", $id);

        $this->response("Product Updated Succesfully", true);
        return;
      }
    }
    $this->response("Invalid Product ID Provided", false);
    return;
  }
}
