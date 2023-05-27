<?php

namespace App\utils;

class File
{
  public static function imageUpload(array $image)
  {
    $allowedFileExtensions = ["jpg", "png", "webp", "gif", "jpeg"];
    $fileExtension = pathinfo($image["name"])["extension"];

    $doesFileExtensionMatches = array_search($fileExtension, $allowedFileExtensions);

    if (is_int($doesFileExtensionMatches)) {
      $imageName = time();
      $imageName .= pathinfo($image["name"])["basename"];
      if (!file_exists(__DIR__ . "/../../public/uploads")) {
        mkdir(__DIR__ . "/../../public/uploads");
      }
      move_uploaded_file($image["tmp_name"], __DIR__ . "/../../public/uploads/$imageName");
      return "/uploads/$imageName";
    } else {
      return false;
    }
  }
}
