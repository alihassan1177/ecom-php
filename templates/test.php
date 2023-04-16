<?php

use App\Category;

$categories = $data["data"]["categories"];

foreach ($categories as $category) {
    $fullCatname = Category::getCategoryFullName($categories, $category["id"]);
    echo count($fullCatname) > 1 ? implode(" - ", $fullCatname) : $fullCatname[0];
}
