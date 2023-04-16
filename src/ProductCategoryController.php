<?php

namespace App;

use App\Controller;

class ProductCategoryController extends Controller
{

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

    public static function getCategoryName(array $categories, int $id)
    {
        foreach ($categories as $category) {
            if ($category["id"] == $id) {
                return $category["name"];
            }
        }

        return "None";
    }

    public function singleCategory(array $params)
    {
        if (isset($_GET["id"]) && $_GET["id"] != "") {
            $id = $_GET["id"];
            if (is_int(intval($id))) {
                $category = Database::getResultsByQuery("SELECT * FROM `categories` WHERE `id` = $id");
                if (count($category) > 0) {

                    $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
                    $products = Database::getResultsByQuery("SELECT * FROM `products`");
                    $productsByCategory = self::getProductsByCategory($products, $categories, $id);

                    $params["categories"] = $categories;
                    $params["products"] = $products;
                    $params["productsByCategory"] = $productsByCategory;
                    // Get First Element of Array
                    $category = array_shift($category);
                    $params["category"] = $category;
                    $pageInfo = ["title" => $category["name"], "description" => ""];
                    $this->renderView($pageInfo, "admin/products/categories/single", "admin", $params);
                    return;
                }
            }
        }

        header("location:/admin/products/categories");
    }


    public static function categoryHasChildren(array $categories, int $id, array $foundCategories = [])
    {
        $childCategories = $foundCategories;

        foreach ($categories as $category) {
            if ($category["parent"] == $id) {
                $childCategories[] = $category;
                $childCategories = self::categoryHasChildren($categories, $category["id"], $childCategories);
            }
        }

        if (count($childCategories) > 0) {
            return $childCategories;
        } else {
            return false;
        }
    }

    public static function getProductsByCategory(array $products, array $categories, int $categoryID, array $foundProducts = [])
    {
        $productsByCategory = $foundProducts;

        $childCategories = self::categoryHasChildren($categories, $categoryID);

        if ($childCategories != false) {
            $productsInChild = [];
            foreach ($childCategories as $childCategory) {
                $result = self::getProductsByCategory($products, $categories, $childCategory["id"], $productsByCategory);
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


    public function deleteCategory()
    {
        if (isset($_POST["id"]) && $_POST["id"] != "") {
            $id = $_POST["id"];
            if (is_int(intval($id))) {
                $category = Database::getResultsByQuery("SELECT * FROM `categories` WHERE `id` = $id");
                $products = Database::getResultsByQuery("SELECT * FROM `products`");
                $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
                if (count($category) > 0) {
                    $category = array_shift($category);
                    $categoryHasProducts = self::getProductsByCategory($products, $categories, $category["id"]);
                    $categoryHasChildren = self::categoryHasChildren($categories, $category["id"]);
                    if (count($categoryHasProducts) > 0 || $categoryHasChildren != false) {
                        $this->response("Unable to Delete Category : " . $category["name"] . " has data", false);
                        return;
                    }
                    Database::onlyExecuteQuery("DELETE FROM `categories` WHERE `id` = $id;");
                    $this->response("Category Deleted Successfully", true);
                    return;
                }
            }
        }

        $this->response("Invalid Category ID Provided", false);
        return;
    }

    public function editCategory(array $params)
    {
        if (isset($_GET["id"]) && $_GET["id"] != "") {
            $id = $_GET["id"];
            if (is_int(intval($id))) {
                $category = Database::getResultsByQuery("SELECT * FROM `categories` WHERE `id` = $id");
                $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
                $params["category"] = $category;
                $params["categories"] = $categories;
                $pageInfo = ["title" => "Edit Category"];
                $this->renderView($pageInfo, "admin/products/categories/edit", "admin", $params);
                return;
            }
        }

        header("location:/admin/products/categories");
        return;
    }

    public function updateCategory()
    {
        $categoryID = isset($_POST["id"]) ? $_POST["id"] : null;
        $categoryName = isset($_POST["name"]) ? $_POST["name"] : null;
        $categoryParent = isset($_POST["parent"]) ? $_POST["parent"] : null;
        $categoryImage = isset($_FILES["image"]) ? $_FILES["image"] : null;

        if (!is_int(intval($categoryID))) {
            $this->response("Category ID is Required", false);
            return;
        }

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

        Database::onlyExecuteQuery("UPDATE `categories` SET `name` = '$categoryName', `parent` = $categoryParent, `image` = '$imageURL' WHERE `id` = $categoryID");
        $this->response("Category Updated Successfully", true);
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

    public function newCategory(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `categories`");
        $params["categories"] = $categories;
        $pageInfo = ["title" => "New Product Category", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/products/categories/new", "admin", $params);
    }
}
