<?php

use App\Category;
use App\ProductCategoryController;

$categories = $data["data"]["categories"];
$products = $data["data"]["products"];

$foundCat = ProductCategoryController::getProductsByCategory($products, $categories, 33);
$children = ProductCategoryController::categoryHasChildren($categories, 33);

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

$data = getCategoryProducts($children, $products);
print_r($data);
print_r($foundCat);
