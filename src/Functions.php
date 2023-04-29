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

  public static function ClientBreadcrumbs()
  {

    $requestURI = parse_url($_SERVER["REQUEST_URI"]);
    $items = explode("/", $requestURI["path"]);

    $current_link = "";

    echo "<div class='d-inline-flex'>";

    for ($i = 0; $i < count($items); $i++) {
      $item = $items[$i];
      $linkName = str_replace(["_"], [" "], $item);

      if ($item != "") {
        if ($i == count($items) - 1) {
          $current_link .= "/" . $item;
          echo <<<LINK
        <p style="text-transform:capitalize" class="m-0">$linkName</p>
        LINK;
        } else {
          $current_link .= "/" . $item;
          echo <<<LINK
        <p class="m-0"><a style='text-transform:capitalize' href="$current_link">$linkName</a></p>
        LINK;
        }
      }
    }
    echo "</div>";
  }

  public static function ClientPageHeader(array $data)
  {
    $pageTitle = $data["page-info"]["title"];
    echo "<div class='container-fluid bg-secondary mb-5'>
        <div class='d-flex flex-column align-items-center justify-content-center' style='min-height: 300px'>
            <h1 class='font-weight-semi-bold text-uppercase mb-3'>$pageTitle</h1>";
    self::ClientBreadcrumbs();
    echo "    </div>
    </div>";
  }

  public static function Breadcrumbs()
  {

    $requestURI = parse_url($_SERVER["REQUEST_URI"]);
    $items = explode("/", $requestURI["path"]);

    $current_link = "";

    echo "<nav aria-label='breadcrumb'>
    <ol style='border:1px solid #e3e6f0' class='breadcrumb bg-white'>";

    for ($i = 0; $i < count($items); $i++) {
      $item = $items[$i];
      $linkName = str_replace(["_"], [" "], $item);

      if ($item != "") {
        if ($i == count($items) - 1) {
          $current_link .= "/" . $item;
          echo <<<LINK
        <li style="text-transform:capitalize" class="breadcrumb-item active">$linkName</li>
        LINK;
        } else {
          $current_link .= "/" . $item;
          echo <<<LINK
        <li class="breadcrumb-item"><a style='text-transform:capitalize' href="$current_link">$linkName</a></li>
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
