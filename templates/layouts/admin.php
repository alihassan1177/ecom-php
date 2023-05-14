<?php

/** @var array $data */
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <?php

  use App\Functions;

  Functions::PageHead($data);

  ?>

  <!-- Custom fonts for this template-->
  <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Bootstrap core JavaScript-->
  <script src="/vendor/jquery/jquery.min.js"></script>
  <script defer src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script defer src="/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script defer src="/js/sb-admin-2.min.js"></script>

  <link href="/client/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="/assets/images/fav-icon.png" type="image/x-icon">
</head>

<body class="overflow-hidden" id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul style="transition: width 200ms ease-in-out;" class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="/admin">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-shopping-bag"></i>
          <span>Products</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin/products">All Products</a>
            <a class="collapse-item" href="/admin/products/new">Add New Product</a>
            <a class="collapse-item" href="/admin/products/categories">Product Categories</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-blog"></i>
          <span>Posts</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin/posts">All Posts</a>
            <a class="collapse-item" href="/admin/posts/new">Add new Post</a>
            <a class="collapse-item" href="/admin/posts/categories">Post Categories</a>
          </div>
        </div>
      </li>


      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="/admin/customers">
          <i class="fas fa-users"></i>
          <span>Customers</span>
        </a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="/admin/orders">
          <i class="fas fa-chart-area"></i>
          <span>Orders</span>
        </a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-bullhorn"></i>
          <span>Marketing</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/admin/banners">Banners</a>
          </div>
        </div>
      </li>


      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="/admin/site_settings">
          <i class="fas fa-fw fa-table"></i>
          <span>Site Settings</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav style="z-index: 10;" class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form id="searchbar-form" action="/admin/results" method="POST" autocomplete="off" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input id="searchbar" list="suggestions" name="query" type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <datalist id="suggestions">
                <option>Products</option>
                <option>Categories</option>
                <option>Posts</option>
              </datalist>
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["admin_data"]["name"] ?? "Admin"; ?></span>
                <img class="img-profile rounded-circle" src="/img/undraw_profile.svg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div style="overflow-y: scroll; height: calc(100vh - 70px)" class="container-fluid pt-4">
          <?php
          if ($_SERVER["REQUEST_URI"] != "/admin") {
            Functions::Breadcrumbs();
          }
          ?>
          {{content}}

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Developed by <a style="text-decoration: underline; text-underline-offset: 4px;" target="_blank" href="https://github.com/alihassan1177">Ali Hassan</a></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button id="logout-btn" class="btn btn-danger">Logout</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    const logoutBtn = document.querySelector("#logout-btn")
    logoutBtn.addEventListener("click", async () => {
      const response = await fetch("/admin/logout")
      window.location.href = "/admin"
    })

    const sidebarToggler = document.querySelector("#sidebarToggle")
    const sidebar = document.querySelector("#accordionSidebar")
    const key = "TOGGLED"

    let data = JSON.parse(localStorage.getItem("TOGGLED")) || {
      value: false
    }

    let {
      value
    } = data

    if (value == true) {
      sidebar.classList.add("toggled")
    } else {
      sidebar.classList.remove("toggled")
    }

    sidebarToggler.addEventListener("click", () => {
      data.value = !value
      localStorage.setItem("TOGGLED", JSON.stringify(data))
    })

    const navItems = document.querySelectorAll(".nav-item")
    // console.log(navItems)
    navItems.forEach(item => {
      const links = item.querySelectorAll(".nav-link, .collapse-item")
      links.forEach(link => {
        if (window.location.href == link.href) {
          item.classList.add("active")
        }
      })
    })
  </script>


  <!-- Searchbar -->

  <script>
    const searchbar = document.querySelector("#searchbar")
    const suggestionsList = document.querySelector("#suggestions")
    const searchbarForm = document.querySelector("#searchbar-form")

    let values = {
      query: ""
    }

    const getData = debounce(
      async (e) => {
        try {
          let value = e.target.value
          values.query = value
          const input = new FormData()
          input.append("query", value)
          const response = await fetch("/admin/search", {
            method: "POST",
            body: input
          })
          const data = await response.json()
          const result = JSON.parse(data.message);

          let optionsHTML = ""
          for (n in result) {
            result[n].forEach(item => {
              optionsHTML += `<option value="${item.name}">${item.name} : ${n}</option>`
            })
          }
          suggestionsList.innerHTML = optionsHTML

        } catch (error) {

        }

      }, 500)

    function debounce(callback, delay) {
      let timer
      return function() {
        let context = this
        let args = arguments
        clearTimeout(timer)
        timer = setTimeout(() => {
          callback.apply(context, args)
        }, delay)
      }
    }

    searchbar.addEventListener("input", getData)

    window.addEventListener("keydown", (e) => {
      if (e.ctrlKey && e.key == "k") {
        e.preventDefault()
        searchbar.focus()
      }
    })
  </script>
</body>

</html>
