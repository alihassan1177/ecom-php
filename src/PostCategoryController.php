<?php

namespace App;

use App\Controller;
use App\Database;

class PostCategoryController extends Controller
{
    public function index(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`;");
        $posts = Database::getResultsByQuery("SELECT * FROM `posts`;");
        $params["categories"] = $categories;
        $params["posts"] = $posts;
        $pageInfo = ["title" => "Post Categories", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/posts/categories/index", "admin", $params);
    }

    public function newCategory(array $params)
    {
        $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`;");
        $params["categories"] = $categories;
        $pageInfo = ["title" => "New Post Category", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "admin/posts/categories/new", "admin", $params);
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


    public function createCategory()
    {
        $categoryName = isset($_POST["name"]) ? $_POST["name"] : null;
        $categoryParent = isset($_POST["parent"]) ? $_POST["parent"] : null;

        if ($categoryName == "") {
            $this->response("Category Name is Required", false);
            return;
        }

        $this->validateCategory($categoryParent);

        Database::onlyExecuteQuery("INSERT INTO `post_categories`(`name`, `parent`) VALUES ('$categoryName',$categoryParent)");
        $this->response("New Category Created", true);
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


    public function singleCategory(array $params)
    {
        if (isset($_GET["id"]) && $_GET["id"] != "") {
            $id = $_GET["id"];
            if (is_int(intval($id))) {
                $category = Database::getResultsByQuery("SELECT * FROM `post_categories` WHERE `id` = $id");
                if (count($category) > 0) {

                    $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`");
                    $posts = Database::getResultsByQuery("SELECT * FROM `posts`");
                    $postsByCategory = self::getPostsByCategory($posts, $categories, $id);

                    $params["categories"] = $categories;
                    $params["posts"] = $posts;
                    $params["postsByCategory"] = $postsByCategory;
                    // Get First Element of Array
                    $category = array_shift($category);
                    $params["category"] = $category;
                    $pageInfo = ["title" => $category["name"], "description" => ""];
                    $this->renderView($pageInfo, "admin/posts/categories/single", "admin", $params);
                    return;
                }
            }
        }

        header("location:/admin/posts/categories");
    }

    public function editCategory(array $params)
    {
        if (isset($_GET["id"]) && $_GET["id"] != "") {
            $id = $_GET["id"];
            if (is_int(intval($id))) {
                $category = Database::getResultsByQuery("SELECT * FROM `post_categories` WHERE `id` = $id");
                $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`");
                $params["category"] = $category;
                $params["categories"] = $categories;
                $pageInfo = ["title" => "Edit Category"];
                $this->renderView($pageInfo, "admin/posts/categories/edit", "admin", $params);
                return;
            }
        }

        header("location:/admin/posts/categories");
        return;
    }

    public function updateCategory()
    {
        $categoryID = isset($_POST["id"]) ? $_POST["id"] : null;
        $categoryName = isset($_POST["name"]) ? $_POST["name"] : null;
        $categoryParent = isset($_POST["parent"]) ? $_POST["parent"] : null;

        if (!is_int(intval($categoryID))) {
            $this->response("Category ID is Required", false);
            return;
        }

        if ($categoryName == "") {
            $this->response("Category Name is Required", false);
            return;
        }

        $this->validateCategory($categoryParent);

        Database::onlyExecuteQuery("UPDATE `post_categories` SET `name` = '$categoryName', `parent` = $categoryParent WHERE `id` = $categoryID");
        $this->response("Category Updated Successfully", true);
    }


    public function deleteCategory()
    {
        if (isset($_POST["id"]) && $_POST["id"] != "") {
            $id = $_POST["id"];
            if (is_int(intval($id))) {
                $category = Database::getResultsByQuery("SELECT * FROM `post_categories` WHERE `id` = $id");
                $posts = Database::getResultsByQuery("SELECT * FROM `posts`");
                $categories = Database::getResultsByQuery("SELECT * FROM `post_categories`");
                if (count($category) > 0) {
                    $category = array_shift($category);
                    $categoryHasProducts = self::getPostsByCategory($posts, $categories, $category["id"]);
                    $categoryHasChildren = self::categoryHasChildren($categories, $category["id"]);
                    if (count($categoryHasProducts) > 0 || $categoryHasChildren != false) {
                        $this->response("Unable to Delete Category : " . $category["name"] . " has data", false);
                        return;
                    }
                    Database::onlyExecuteQuery("DELETE FROM `post_categories` WHERE `id` = $id;");
                    $this->response("Category Deleted Successfully", true);
                    return;
                }
            }
        }

        $this->response("Invalid Category ID Provided", false);
        return;
    }

    private static function postsByCategory($posts, $id)
    {
        $foundPosts = [];
        foreach ($posts as $product) {
            if ($product["category_id"] == $id) {
                $foundPosts[] = $product;
            }
        }
        return $foundPosts;
    }


    private static function getPosts($children, $Posts, $foundProds = [])
    {
        $result[] = $foundProds;
        if (is_array($children)) {
            foreach ($children as $child) {
                $result[] = self::postsByCategory($Posts, $child["id"]);
            }
        }
        return $result;
    }

    public static function getPostsByCategory(array $posts, array $categories, int $categoryID)
    {
        $children = self::categoryHasChildren($categories, $categoryID);
        $postsByCategory = self::getPosts($children, $posts);
        $postsByCategory = array_merge(...$postsByCategory);
        return $postsByCategory;
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
}
