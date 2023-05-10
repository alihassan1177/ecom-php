<!DOCTYPE html>
<html lang="en">

<head>

  <?php

  use App\Functions;
  use App\Category;
  use App\Database;

  Functions::PageHead($data);

  $categories = Database::getResultsByQuery("SELECT * FROM `categories`;");

  ?>

  <!-- Favicon -->
  <link href="/client/img/favicon.ico" rel="icon">

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

  <!-- Libraries Stylesheet -->
  <link href="/client/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="/client/css/style.css" rel="stylesheet">
</head>

<body>
  <!-- Topbar Start -->
  <div class="container-fluid">
    <div class="row align-items-center py-3 px-xl-5">
      <div class="col-lg-3 d-none d-lg-block">
        <a href="/" class="text-decoration-none">
          <h1 style="display: inline;" class="m-0 display-5 font-weight-semi-bold"><?= $_ENV["SITE_NAME"] ?></h1>
        </a>
      </div>
      <div class="col-lg-6 col-12 text-left">
        <form action="">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search for products">
            <div class="input-group-append">
              <span class="input-group-text bg-transparent text-primary">
                <i class="fa fa-search"></i>
              </span>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-3 col-12 mt-1 mt-lg-0 text-right">
        <a href="" class="btn border">
          <i class="fas fa-heart text-primary"></i>
          <span class="badge">0</span>
        </a>
        <a href="" class="btn border">
          <i class="fas fa-shopping-cart text-primary"></i>
          <span class="badge">0</span>
        </a>
      </div>
    </div>
  </div>
  <!-- Topbar End -->


  <!-- Navbar Start -->
  <div class="container-fluid">
    <div class="row border-top px-xl-5">

      <div style="padding:0.50rem" class="col-12">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
          <a href="/" class="text-decoration-none d-block d-lg-none">
            <h1 class="m-0 display-5 font-weight-semi-bold"><?= $_ENV["SITE_NAME"] ?></h1>
          </a>
          <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav mr-auto py-0">
              <a href="/" class="nav-item nav-link">Home</a>
              <a href="/shop" class="nav-item nav-link">Shop</a>
              <a href="/shop/details" class="nav-item nav-link">Shop Detail</a>
              <?php if ($categories != null && count($categories) > 0): ?>
              <div class="nav-item dropdown">
                <a href="/shop/category" class="nav-link dropdown-toggle" data-toggle="dropdown">Categories</a>
                <div class="dropdown-menu rounded-0 m-0">
                  <?php 

                  for ($i=0; $i < count($categories); $i++) { 
                    $category = $categories[$i];
                    $id = $category["id"];
                    $categoryName = Category::getCategoryName($categories, $category["id"]);
                    $fullCatname = implode(Category::$categorySeprator, $categoryName);

                    echo "<a href='/shop/category?id=$id' class='dropdown-item'>$fullCatname</a>";
                  }

                  ?>
                </div>
              </div>
              <?php  endif; ?>
              <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                <div class="dropdown-menu rounded-0 m-0">
                  <a href="/cart" class="dropdown-item">Shopping Cart</a>
                  <a href="/checkout" class="dropdown-item">Checkout</a>
                </div>
              </div>
              <a href="/contact" class="nav-item nav-link">Contact</a>
            </div>
            <div class="navbar-nav ml-auto py-0">
              <a href="/login" class="nav-item nav-link">Login</a>
              <a href="/register" class="nav-item nav-link">Register</a>
            </div>
          </div>
        </nav>

      </div>
    </div>
  </div>

  <?php

  if ($_SERVER["REQUEST_URI"] != "/") {
    Functions::ClientPageHeader($data);
  }
  ?>

  <!-- Content Begin -->
  {{content}}


  <!-- Footer Start -->
  <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
      <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
        <a href="/" class="text-decoration-none">
          <h1 class="mb-4 display-5 font-weight-semi-bold"><?= $_ENV["SITE_NAME"] ?></h1>
        </a>
        <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p>
        <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
        <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
        <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
      </div>
      <div class="col-lg-8 col-md-12">
        <div class="row">
          <div class="col-md-4 mb-5">
            <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
            <div class="d-flex flex-column justify-content-start">
              <a class="text-dark mb-2" href="/"><i class="fa fa-angle-right mr-2"></i>Home</a>
              <a class="text-dark mb-2" href="/shop"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
              <a class="text-dark mb-2" href="/cart"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
              <a class="text-dark mb-2" href="/checkout"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
              <a class="text-dark" href="/checkout"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
            </div>
          </div>
          
          <div class="col-md-8 mb-5">
            <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
            <form action="">
              <div class="form-group">
                <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
              </div>
              <div class="form-group">
                <input type="email" class="form-control border-0 py-4" placeholder="Your Email" required="required" />
              </div>
              <div>
                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row border-top border-light mx-xl-5 py-4">
      <div class="col-md-6 px-xl-0">
        <p class="mb-md-0 text-center text-md-left text-dark">
          &copy; <a class="text-dark font-weight-semi-bold" href="/"><?= $_ENV["SITE_NAME"] ?></a>. All Rights Reserved. Designed
          by
          <a class="text-dark font-weight-semi-bold" target="_blank" href="https://github.com/alihassan1177">Ali Hassan</a>
        </p>
      </div>
      <div class="col-md-6 px-xl-0 text-center text-md-right">
        <img class="img-fluid" src="/client/img/payments.png" alt="">
      </div>
    </div>
  </div>
  <!-- Footer End -->


  <!-- Back to Top -->
  <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


  <!-- JavaScript Libraries -->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script defer src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/client/lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="/client/lib/easing/easing.min.js"></script>
  <!-- Contact Javascript File -->
  <script src="/client/mail/jqBootstrapValidation.min.js"></script>
  <script src="/client/mail/contact.js"></script>

  <!-- Template Javascript -->
  <script src="/client/js/main.js"></script>

  <script>
    const navLinks = document.querySelectorAll(".nav-link, .dropdown-item")

    navLinks.forEach(link => {
      if (window.location.href == link.href) {
        link.classList.add("active")
      }
    })
  </script>
</body>

</html>
