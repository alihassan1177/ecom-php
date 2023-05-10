<?php

use App\Category;
use App\Database;
use App\ProductCategoryController;

$categories = $data["data"]["categories"];
$postCategories = $data["data"]["postCategories"];

$products = $data["data"]["products"];

$foundCat = ProductCategoryController::getProductsByCategory($products, $categories, 33);
$children = Category::categoryHasChildren($categories, 33);

function getProductsByCategory($products, $id)
{
    $foundProducts = [];
    foreach ($products as $product) {
        if ($product["category_id"] == $id) {
            $foundProducts[] = $product;
        }
    }
    return $foundProducts;
}


echo "<pre>";

//print_r($children);

function getProducts($children, $products, $foundProds = [])
{
    $result[] = $foundProds;
    foreach ($children as $child) {
        $result[] = getProductsByCategory($products, $child["id"], $result);
    }
    return $result;
}

function getCategoryProducts($children, $products)
{
    $products = getProducts($children, $products);
    $products = array_merge(...$products);
    return $products;
}

function getCategoriesExceptChildren(array $categories, int $id)
{
    $children = Category::categoryHasChildren($categories, $id);
    if (is_array($children)) {
        if (count($children) == (count($categories) - 1)) {
            return;
        }
        for ($i=0; $i <= count($children); $i++) { 
            $child = $children[$i];
            for ($j=0; $j <= count($categories); $j++) { 
                $category = $categories[$j];
                if ($category["id"] == $child["id"] || $category["id"] == $id) {
                    unset($categories[$j]);
                }
            }
        }

        // for ($i=0; $i <= count($categories); $i++) { 
        //     if ($categories[$i] == null) {
        //         unset($categories[$i]);
        //     }
        // }

    }
    return $categories;
}
// echo "----------------------------- Post Categories except Children ---------------------------------<br>";
// print_r(getCategoriesExceptChildren($postCategories, 11));
//echo "----------------------------- Categories except Children ---------------------------------<br>";
//print_r(getCategoriesExceptChildren($categories, 37));
//echo "--------------------------------------------------------------<br>";

// $conn = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
// $query = mysqli_query($conn, "SELECT * FROM `ecom`.`products` WHERE (CONVERT(`name` USING utf8) LIKE '%e%')");
// $results = mysqli_fetch_all($query, MYSQLI_ASSOC);

$results = Database::getResultsByQuery("SELECT * FROM `ecom`.`products` WHERE (CONVERT(`name` USING utf8) LIKE '%e%')");

$productsByCategory = ProductCategoryController::getProductsByCategory($products, $categories, 37);

//$productsByCategory  = getProductsByCategory($products, 37);

print_r($productsByCategory);

//print_r($results);
