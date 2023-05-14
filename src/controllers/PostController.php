<?php

namespace App;

use App\Controller;

class PostController extends Controller
{
  public function index(array $params)
  {
    $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`;");
    $posts = Database::getResultsByQuery("SELECT * FROM `posts`;");
    $params["categories"] = $categories;
    $params["posts"] = $posts;

    $pageInfo = ["title" => "Posts", "description" => "Posts Page Admin Panel"];
    $this->renderView($pageInfo, "admin/posts/index", "admin", $params);
  }

  public function newPost(array $params)
  {
    $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`;");
    $params["categories"] = $categories;
    $pageInfo = ["title" => "New Post", "description" => "Posts Page Admin Panel"];
    $this->renderView($pageInfo, "admin/posts/new", "admin", $params);
  }

  public function singlePost(array $params)
  {
    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $id = $_GET["id"];
      if (is_int(intval($id))) {
        $post = Database::getResultsByQuery("SELECT * FROM `posts` WHERE `id` = $id");
        if (count($post) > 0) {
          $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`");
          $params["categories"] = $categories;
          // Get First Element of Array
          $post = array_shift($post);
          $params["post"] = $post;
          $pageInfo = ["title" => $post["name"], "description" => $post["short_description"]];
          $this->renderView($pageInfo, "admin/posts/single", "admin", $params);
          return;
        }
      }
    }

    header("location:/admin/posts");
  }


  public function editPost(array $params)
  {
    if (isset($_GET["id"]) && $_GET["id"] != "") {
      $id = $_GET["id"];
      if (is_int(intval($id))) {
        $post = Database::getResultsByQuery("SELECT * FROM `posts` WHERE `id` = $id");
        $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`");
        $post = $post[0];
        $params["post"] = $post;
        $params["categories"] = $categories;
        $pageInfo = ["title" => "Edit Category"];
        $this->renderView($pageInfo, "admin/posts/edit", "admin", $params);
        return;
      }
    }

    header("location:/admin/posts");
    return;
  }

  public function deletePost()
  {
    if (isset($_POST["id"]) && $_POST["id"] != "") {
      $id = $_POST["id"];
      if (is_int(intval($id))) {
        $product = Database::getResultsByQuery("SELECT * FROM `posts` WHERE `id` = $id;");
        $product = $product[0];
        if (count($product) > 0) {
          $oldImagePath = __DIR__ . "/../public" . $product["image"];
          if (file_exists($oldImagePath) && $product["image"] != "") {
            unlink($oldImagePath);
          }
          Database::onlyExecuteQuery("DELETE FROM `posts` WHERE `id` = $id;");
          $this->response("Post Deleted Successfully", true);
          return;
        }
      }
    }
    $this->response("Invalid Post ID Provided", false);
    return;
  }


  public function createPost()
  {
    $postImage = isset($_FILES["image"]) ? $_FILES["image"] : null;
    $postCategory = isset($_POST["category_id"]) ? $_POST["category_id"] : null;
    $postName = isset($_POST["name"]) ? $_POST["name"] : null;
    $postShortDescription = isset($_POST["short_description"]) ? htmlentities($_POST["short_description"]) : null;
    $postDescription = isset($_POST["description"]) ? htmlentities($_POST["description"]) : null;

    $this->validateCategory($postCategory);

    if (empty($postName)) {
      $this->response("Post Name is Required", false);
      return;
    }

    $imageURL = "";
    if (!empty($postImage)) {
      $imageURL .= $this->imageUpload($postImage);
      if (!$imageURL) {
        $this->response("FileType not Allowed : " . $postImage["type"], false);
        return;
      }
    }

    $queryParams = [
      "name" => $postName,
      "image" => $imageURL,
      "short_description" => $postShortDescription,
      "description" => $postDescription,
      "category_id" => $postCategory,
    ];

    $this->insertData($queryParams, "posts");

    $this->response("New Post Created Succesfully", true);
  }

  private function imageUpload(array $image)
  {
    $allowedFileExtensions = ["jpg", "png", "webp", "gif", "jpeg"];
    $fileExtension = pathinfo($image["name"])["extension"];

    $doesFileExtensionMatches = array_search($fileExtension, $allowedFileExtensions);

    if (is_int($doesFileExtensionMatches)) {
      $imageName = time();
      $imageName .= pathinfo($image["name"])["basename"];
      if (!file_exists(__DIR__ . "/../public/uploads")) {
        mkdir(__DIR__ . "/../public/uploads");
      }
      move_uploaded_file($image["tmp_name"], __DIR__ . "/../public/uploads/$imageName");
      return "/uploads/$imageName";
    } else {
      return false;
    }
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

  public function updatePost()
  {
    if (isset($_POST["id"]) && $_POST["id"] != "") {
      $id = $_POST["id"];
      if (is_int(intval($id))) {

        $postImage = isset($_FILES["image"]) ? $_FILES["image"] : null;
        $postCategory = isset($_POST["category_id"]) ? $_POST["category_id"] : null;
        $postName = isset($_POST["name"]) ? $_POST["name"] : null;
        $postShortDescription = isset($_POST["short_description"]) ? htmlentities($_POST["short_description"]) : null;
        $postDescription = isset($_POST["description"]) ? htmlentities($_POST["description"]) : null;

        $this->validateCategory($postCategory);

        if (empty($postName)) {
          $this->response("Product Name is Required", false);
          return;
        }

        $post = Database::getResultsByQuery("SELECT * FROM `posts` WHERE `id` = $id");
        $post = $post[0];

        $imageURL = "";
        if (!empty($postImage)) {
          unlink(__DIR__ . "/../public" . $post["image"]);
          $imageURL .= $this->imageUpload($postImage);
          if (!$imageURL) {
            $this->response("FileType not Allowed : " . $postImage["type"], false);
            return;
          }
        }

        $queryParams = [
          "name" => $postName,
          "image" => $imageURL,
          "short_description" => $postShortDescription,
          "description" => $postDescription,
          "category_id" => $postCategory,
        ];

        $this->updateData($queryParams, "posts", $id);

        $this->response("Post Updated Succesfully", true);
        return;
      }
    }
    $this->response("Invalid Post ID Provided", false);
    return;
  }


  private function validateCategory(int $categoryID)
  {
    if (empty($categoryID)) {
      $categoryID = 0;
    } elseif ($categoryID !== 0) {
      $availableCategories = Database::getResultsByQuery("SELECT * FROM `post_categories` WHERE `id` = $categoryID;");
      if (count($availableCategories) == 0) {
        $this->response("Selected Category not Available : " . $categoryID, false);
        return;
      }
    }
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
}
