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

    echo "<div class='d-inline-flex'>
    <p class='m-0'><a style='text-transform:capitalize' href='/'>Home</a></p>
    <p class='m-0 px-2'>-</p>";

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
        <p class="m-0 px-2">-</p>
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

  public static function relatedProducts(array $products)
  {
    if (count($products) > 0) {
      echo ' 
      
    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="/client/img/product-1.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="/client/img/product-2.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="/client/img/product-3.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="/client/img/product-4.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                    <div class="card product-item border-0">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="/client/img/product-5.jpg" alt="">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">Colorful Stylish Shirt</h6>
                            <div class="d-flex justify-content-center">
                                <h6>$123.00</h6><h6 class="text-muted ml-2"><del>$123.00</del></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->


    ';
    }
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
