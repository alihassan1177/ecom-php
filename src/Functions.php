<?php

namespace App;

class Functions
{
  public static function getTemplate(string $name, array $data = [])
  {
    ob_start();
    require_once __DIR__ . "/../templates/$name.php";
    return ob_get_clean();
  }

  public static function getLayout(string $name, string $template, array $data)
  {
    ob_start();
    require_once __DIR__ . "/../templates/layouts/$name.php";
    $layout = ob_get_clean();
    $page = str_replace("{{content}}", $template, $layout);
    echo $page;
  }

  public static function Scripts()
  {
    echo <<<HTML
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <script defer src="/assets/js/bootstrap.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="/assets/images/fav-icon.png" type="image/x-icon">
    HTML;
  }

  public static function Breadcrumbs()
  {

    $requestURI = parse_url($_SERVER["REQUEST_URI"]);
    $items = explode("/", $requestURI["path"]);

    $current_link = "";

    echo "<nav aria-label='breadcrumb'>
    <ol class='breadcrumb'>";

    for ($i = 0; $i < count($items); $i++) {
      $item = $items[$i];
      if ($item != "") {
        if ($i == count($items) - 1) {
          $current_link .= "/" . $item;
          echo <<<LINK
        <li style="text-transform:capitalize" class="breadcrumb-item active">$item</li>
        LINK;
        } else {
          $current_link .= "/" . $item;
          echo <<<LINK
        <li class="breadcrumb-item"><a style='text-transform:capitalize' href="$current_link">$item</a></li>
        LINK;
        }
      }
    }


    echo "</ol></nav>";
  }
  
  public static function PageHead(array $data)
  {
    $pageTitle = $data["page-info"]["title"] ?? $_ENV["SITE_NAME"];
    $pageDesc = $data["page-info"]["description"] ?? "";
    $pageAuthor = $data["page-info"]["author"] ?? $_ENV["SITE_NAME"];
    $siteName = $_ENV["SITE_NAME"];

    echo <<<HTML
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="$pageDesc">
    <meta name="author" content="$pageAuthor">
    <title>$pageTitle - $siteName</title>
    HTML;
  }
}
