<?php

namespace App;

use App\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/index", "admin");
    }

    public function categories(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
        $products = Database::getResultsByQuery("SELECT * FROM `products`");
        $params["categories"] = $categories;
        $params["products"] = $products;
        
        $pageInfo = ["title" => "Product Categories", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/categories/index", "admin", $params);
    }

    public function newProduct()
    {
        $pageInfo = ["title" => "New Product", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/new", "admin");
    }

    public function newCategory(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
        $params["categories"] = $categories;
        $pageInfo = ["title" => "New Product Category", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/categories/new", "admin", $params);
    }

    public function createCategory()
    {
        $categoryName = $_POST["name"];
        $categoryParent = $_POST["parent"];
        $categoryImage = $_FILES["image"];

        if ($categoryName == "") {
            $this->response("Category Name is Required", false);
            return;
        }

        if (empty($categoryParent)) {
            $categoryParent = 0;
        } elseif ($categoryParent !== 0) {
            $availableCategories = Database::getResultsByQuery("SELECT * FROM `categories` WHERE `id` = $categoryParent");
            if (count($availableCategories) == 0) {
                $this->response("Selected Parent Category not Available", false);
                return;
            }
        }

        // File Extension Validation
        $imageURL = "";
        if (!empty($categoryImage)) {

            $allowedFileExtensions = ["jpg", "png", "webp", "gif", "jpeg"];
            $fileExtension = pathinfo($categoryImage["name"])["extension"];

            $doesFileExtensionMatches = array_search($fileExtension, $allowedFileExtensions);

            if (!empty($doesFileExtensionMatches)) {
                $imageName = time();
                $imageName .= pathinfo($categoryImage["name"])["basename"];
                move_uploaded_file($categoryImage["tmp_name"], __DIR__ . "/../public/uploads/$imageName");
                $imageURL .= "/uploads/$imageName";
            } else {
                $this->response("FileType not Allowed : " . $categoryImage["type"], false);
                return;
            }
        }

        Database::onlyExecuteQuery("INSERT INTO `categories`(`name`, `parent`, `image`) VALUES ('$categoryName',$categoryParent,'$imageURL')");
        $this->response("New Category Created", true);
    }

    public static function getCategoryParentName(array $categories, int $id)
    {
        foreach ($categories as $category) {
            if ($category["id"] == $id) {
                return $category["name"];
            }
        }

        return "None";
    }

    public static function getProductsByCategory(array $products, int $categoryID)
    {
        return array_filter($products, function($product) {
            global $categoryID;
            if ($product["category_id"] == $categoryID) {
                return $product;
            }
        });
    }
}
