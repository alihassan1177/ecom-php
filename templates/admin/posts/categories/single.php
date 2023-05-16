<?php

use App\controllers\PostCategoryController;

$category = $data["data"]["category"];
$categories = $data["data"]["categories"];
$postsByCategory = $data["data"]["postsByCategory"];

?>
<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div id="alert" class="alert d-none"></div>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Category Details</h1>
    <a href="/admin/posts/categories/edit?id=<?= $category["id"] ?>" class="d-none d-sm-inline-block btn mx-2 btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Edit Category</a>
    <a id="delete-btn" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Delete Category</a>
</div>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Category Details</h6>
    </div>
    <div class="card-body">
        <div style="row-gap: 20px;" class="row flex-row-reverse">
            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-1"><strong>Category Name:</strong></p>
                    <p><?= $category["name"] ?></p>
                </div>
                <div class="mb-3">
                    <p class="mb-1"><strong>Sub Categories:</strong></p>
                    <?php
                    $childCategories = PostCategoryController::categoryHasChildren($categories, $category["id"]);
                    if ($childCategories != false) {
                        $categoryNames = [];
                        foreach ($childCategories as $childCategory) {
                            $categoryID = $childCategory["id"];
                            $categoryName = $childCategory["name"];

                            echo "<a href='/admin/posts/categories/details?id=$categoryID'>$categoryName</a>, ";
                        }
                    } else {
                        echo "None";
                    }
                    ?>
                </div>
            </div>
            <div class="col-12">
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
                            foreach ($postsByCategory as $post) :
                                $i++;
                                $categoryName = PostCategoryController::getCategoryName($categories, $post["category_id"]);
                            ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><a href="/admin/posts/details?id=<?= $post["id"] ?>"><?= $post["name"] ?></a></td>
                                    <td><?= $categoryName ?></td>
                                    <td><?= $post["short_description"] ?></td>

                                </tr>
                            <?php endforeach; ?>
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
    </div>
</div>

<script defer src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script defer src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script defer src="/js/demo/datatables-demo.js"></script>


<script>
    const deleteBtn = document.querySelector("#delete-btn")
    const alert = document.querySelector("#alert")

    deleteBtn.addEventListener("click", async (e) => {
        e.preventDefault()

        deleteBtn.classList.add("disabled")
        alert.classList.add("d-none")
        if (window.confirm("Delete this Category")) {
            const data = new FormData()
            data.append("id", <?= $category["id"] ?>)
            const response = await fetch("/admin/posts/categories/delete", {
                method: "POST",
                body: data
            })
            const result = await response.json()
            alert.classList.remove("d-none")
            alert.innerText = result.message
            if (result.status == true) {
                alert.classList.add("alert-success")
                alert.classList.remove("alert-danger")
                window.location.href = "/admin/posts/categories"
            } else {
                alert.classList.add("alert-danger")
                alert.classList.remove("alert-success")
                deleteBtn.classList.remove("disabled")
            }
        } else {
            deleteBtn.classList.remove("disabled")
        }
    })
</script>