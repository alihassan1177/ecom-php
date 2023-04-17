<?php

namespace App;

class Category
{
    public static $categorySeprator = " > ";
    public static function getCategoryFullName(array $categories, int $id, array $foundName = [])
    {
        $name = $foundName;
        foreach ($categories as $category) {
            if ($id == $category["id"]) {
                $name[] = $category["name"];
                if ($category["parent"] != 0) {
                    return self::getCategoryFullName($categories, $category["parent"], $name);
                }
            }
        }
        return array_reverse($name);
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
