<?php

namespace App;

class Category
{
    public static $categorySeprator = " > ";

    public static function getCategoryName(array $categories, int $id, array $foundName = [])
    {
        $name = $foundName;
        foreach ($categories as $category) {
            if ($id == $category["id"]) {
                $name[] = $category["name"];
                if ($category["parent"] != 0) {
                    return self::getCategoryName($categories, $category["parent"], $name);
                }
            }
        }
        $fullName = array_reverse($name);

        if (count($fullName) > 0) {
            return  $fullName;
        } else {
            return ["None"];
        }
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

    public static function getCategoriesExceptChildren(array $categories, int $id)
    {
        $children = self::categoryHasChildren($categories, $id);
        if (is_array($children)) :
            for ($i = 0; $i < count($children); $i++) {
                $child = $children[$i];
                for ($j = 0; $j < count($categories); $j++) {
                    $category = $categories[$j];
                    if ($category["id"] == $child["id"]) {
                        unset($categories[$j]);
                    }
                }
            }
        endif;
        return $categories;
    }
}
