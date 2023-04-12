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

    public function newProduct(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
        $params["categories"] = $categories;
        $pageInfo = ["title" => "New Product", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/new", "admin", $params);
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

        $this->validateCategory($categoryParent);

        $imageURL = "";
        if (!empty($categoryImage)) {
            $imageURL .= $this->imageUpload($categoryImage);
            if (!$imageURL) {
                $this->response("FileType not Allowed : " . $categoryImage["type"], false);
                return;
            }
        }

        Database::onlyExecuteQuery("INSERT INTO `categories`(`name`, `parent`, `image`) VALUES ('$categoryName',$categoryParent,'$imageURL')");
        $this->response("New Category Created", true);
    }

    private function validateCategory(int $categoryID)
    {
        if (empty($categoryID)) {
            $categoryID = 0;
        } elseif ($categoryID !== 0) {
            $availableCategories = Database::getResultsByQuery("SELECT * FROM `categories` WHERE `id` = $categoryID;");
            if (count($availableCategories) == 0) {
                $this->response("Selected Category not Available", false);
                return;
            }
        }
    }

    private function imageUpload(array $image)
    {
        $allowedFileExtensions = ["jpg", "png", "webp", "gif", "jpeg"];
        $fileExtension = pathinfo($image["name"])["extension"];

        $doesFileExtensionMatches = array_search($fileExtension, $allowedFileExtensions);

        if (!empty($doesFileExtensionMatches)) {
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
        return array_filter($products, function ($product) {
            global $categoryID;
            if ($product["category_id"] == $categoryID) {
                return $product;
            }
        });
    }

    public function createProduct()
    {
        $productImage = $_FILES["image"];
        $productCategory = $_POST["category_id"];
        $productName = $_POST["name"];
        $productQuantity = $_POST["quantity"];
        $productShortDescription = htmlentities($_POST["short_description"]);
        $productDescription = htmlentities($_POST["description"]);
        $productPrice = $_POST["price"];

        $this->validateCategory($productCategory);

        if (empty($productName)) {
            $this->response("Product Name is Required", false);
            return;
        }

        $imageURL = "";
        if (!empty($productImage)) {
            $imageURL .= $this->imageUpload($productImage);
            if (!$imageURL) {
                $this->response("FileType not Allowed : " . $productImage["type"], false);
                return;
            }
        }

        Database::onlyExecuteQuery("INSERT INTO `products`(`name`, `image`, `short_description`, `description`, `category_id`, `quantity`, `price`) VALUES ('$productName','$imageURL','$productShortDescription','$productDescription',$productCategory,$productQuantity,$productPrice)");
        
        $this->response("New Product Created Succesfully", true);
    }
}
