<?php

use App\controllers\Category;
use App\controllers\ProductCategoryController;

$categories = $data["data"]["categories"];
$products = $data["data"]["products"];

?>

<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Categories</h1>
    <a href="/admin/products" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
        <i class="fas fa-filter fa-sm text-white-50"></i> Products</a>
    <a href="/admin/products/categories/new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add new Category</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="category-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Products Quantity</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $placeholderImage = "/img/product-placeholder.png";
                    $i = 0;
                    foreach ($categories as $category) :
                        $i++;
                        $parentCategoryName = Category::getCategoryName($categories, $category["parent"]);
                        $productsCount = count(ProductCategoryController::getProductsByCategory($products, $categories, $category["id"]));
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td style="max-width: max-content;">
                                <img style="object-fit: cover; width:50px;" height="50" src="<?php echo ($category["image"] != "") ? $category["image"] : $placeholderImage;  ?>" />
                            </td>
                            <td style="text-transform:capitalize"><a href="/admin/products/categories/details?id=<?= $category["id"] ?>">
                                    <?= $category["name"] ?></a>
                            </td>
                            <td><?= implode(Category::$categorySeprator, $parentCategoryName) ?></td>
                            <td><?= $productsCount  ?></td>

                        </tr>
                    <?php

                    endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Products Quantity</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category-table').DataTable();
    });
</script>