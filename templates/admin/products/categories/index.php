<?php

$categories = $data["data"]["categories"];

?>

<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Categories</h1>
    <a href="/admin/products" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
        <i class="fas fa-download fa-sm text-white-50"></i> Products</a>
    <a href="/admin/products/categories/new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Add new Category</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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

                    <?php foreach ($categories as $category) : $i = 0 ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td style="max-width: max-content;"><img style="object-fit: cover;" width="100" height="100" src="/img/product-placeholder.png" /></td>
                            <td style="text-transform:capitalize"><?= $category["name"] ?></td>
                            <td><?php
                                foreach ($categories as $item) {
                                    if ($category["parent"] == $item["id"]) {
                                        echo $item["name"];
                                    } else {
                                        echo "None";
                                    }
                                }
                                ?></td>
                        </tr>
                    <?php
                        $i++;
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
<script src="/js/demo/datatables-demo.js"></script>