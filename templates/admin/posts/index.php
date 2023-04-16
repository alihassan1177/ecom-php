<?php

use App\PostCategoryController;

$categories = $data["data"]["categories"];
$posts = $data["data"]["posts"];

?>

<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Posts</h1>
    <a href="/admin/posts/categories" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
        <i class="fas fa-filter fa-sm text-white-50"></i> Post Categories</a>
    <a href="/admin/posts/new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add new Post</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Posts</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Short Description</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $i = 0;
                    foreach ($posts as $post) :
                        $i++;
                        $categoryName = PostCategoryController::getCategoryName($categories, $post["category_id"]);
                    ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td style="text-transform:capitalize"><a href="/admin/posts/details?id=<?= $post["id"] ?>">
                                    <?= $post["name"] ?></a>
                            </td>
                            <td><?= $categoryName ?></td>
                            <td><?= $post["short_description"]  ?></td>

                        </tr>
                    <?php

                    endforeach; ?>


                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Short Description</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/js/demo/datatables-demo.js"></script>