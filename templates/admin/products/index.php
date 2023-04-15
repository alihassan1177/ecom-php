<?php

use App\ProductCategoryController;

$products = $data["data"]["products"];
$categories = $data["data"]["categories"];

?>

<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Products</h1>
    <a href="/admin/products/categories" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
        <i class="fas fa-filter fa-sm text-white-50"></i> Product Categories</a>
    <a href="/admin/products/new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add new Product</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $placeholderImage = "/img/product-placeholder.png";
                    foreach ($products as $product) :
                        $i++;
                        $categoryName = ProductCategoryController::getCategoryName($categories, $product["category_id"]);
                        $productImage = $product["image"] != "" ? $product["image"] : $placeholderImage;
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td style="max-width: max-content;">
                                <img style="object-fit: cover;" width="50" height="50" src="<?php echo $productImage  ?>" />
                            </td>
                            <td><a href="/admin/products/details?id=<?= $product["id"] ?>"><?= $product["name"] ?></a></td>
                            <td><?= $categoryName ?></td>
                            <td><?= $product["price"] ?></td>
                            <td><?= $product["quantity"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/js/demo/datatables-demo.js"></script>