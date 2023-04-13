<?php

namespace App;

use App\Controller;

class ProductController extends Controller
{
    public function index(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
        $products = Database::getResultsByQuery("SELECT * FROM `products`");
        $params["categories"] = $categories;
        $params["products"] = $products;

        $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/index", "admin", $params);
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
        $categoryName = isset($_POST["name"]) ? $_POST["name"] : null;
        $categoryParent = isset($_POST["parent"]) ? $_POST["parent"] : null;
        $categoryImage = isset($_FILES["image"]) ? $_FILES["image"] : null;

        if ($categoryName == "") {
            $this->response("Category Name is Required", false);
            return;
        }

        $this->validateCategory($categoryParent);

        $imageURL = "";
        if (!empty($categoryImage) && $categoryImage != null) {
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
                $this->response("Selected Category not Available : " . $categoryID, false);
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

    public static function getCategoryName(array $categories, int $id)
    {
        foreach ($categories as $category) {
            if ($category["id"] == $id) {
                return $category["name"];
            }
        }

        return "None";
    }

    public static function getProductsByCategory(array $products, array $categories, int $categoryID)
    {
        $productsByCategory = [];

        $childCategories = self::categoryHasChildren($categories, $categoryID);

        if ($childCategories != false) {
            $productsInChild = [];
            foreach ($childCategories as $childCategory) {
                $result = self::getProductsByCategory($products, $categories, $childCategory["id"]);
                $productsInChild = array_merge($result, $productsInChild);
            }
            $productsByCategory = array_merge($productsByCategory, $productsInChild);
        }

        foreach ($products as $product) {
            if ($product["category_id"] == $categoryID) {
                array_push($productsByCategory, $product);
            }
        }
        return $productsByCategory;
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
            $imageURL .= $this->imageUpload($productImage);
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

    public static function categoryHasChildren(array $categories, int $categoryID){
        $childCategories = [];
        foreach($categories as $category){
            if ($category["parent"] == $categoryID) {
                $childCategories[] = $category;
            }
        }
        if (count($childCategories) > 0) {
            return $childCategories;
        }else{
            return false;
        }
    }
}
