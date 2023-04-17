<?php

use App\Category;
use App\ProductCategoryController;

$categories = $data["data"]["categories"];
$products = $data["data"]["products"];

$foundCat = ProductCategoryController::getProductsByCategory($products, $categories, 33);
$children = ProductCategoryController::categoryHasChildren($categories, 33);

// $products = [];
// foreach ($children as $child) {
//     $foundProds = getProductsByCategory($products, $child["id"]);
//     $products = array_merge($products, $foundProds);
// }

function getProductsByCategory($products , $id){
    $foundProducts = [];
    foreach ($products as $product) {
        if ($product["category_id"] == $id) {
            $foundProducts[] = $product;
        }
    }
    return $foundProducts;
}


echo "<pre>";

foreach($children as $child){
    $foundProds = getProductsByCategory($products, $child["id"]);
    print_r($foundProds);
}