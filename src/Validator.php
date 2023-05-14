<?php

namespace App;

class Validator
{
  public static function validateInput(array $params): array
  {
    $result = [];
    $errors = [];

    foreach ($params as $key => $value) {
      switch ($key) {
        case "email":
          $result[$key] = filter_var($value, FILTER_VALIDATE_EMAIL);
          break;
        case "password":
          $result[$key] = $value;
          break;
        default:
          $result[$key] = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          break;
      }
    }

    foreach ($result as $key => $value) {
      if ($value == false) {
        $errors[$key] = $params[$key] . " is not valid a " . $key;
      }
    }

    return ["values" => $result, "errors" => $errors];
  }

  public static function validateFile()
  {
  }
}
