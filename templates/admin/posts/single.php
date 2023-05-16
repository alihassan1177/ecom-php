<?php

use App\controllers\PostCategoryController;

$post = $data["data"]["post"];
$categories = $data["data"]["categories"];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Product Details</h1>
    <a href="/admin/posts/edit?id=<?= $post["id"] ?>" class="d-none d-sm-inline-block btn mx-2 btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Edit Post</a>
    <a id="delete-btn" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Delete Post</a>
</div>
<div id="alert" class="alert d-none"></div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Post Details</h6>
    </div>
    <div class="card-body">
        <div style="row-gap: 20px;" class="row flex-row-reverse">
            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-1"><strong>Post Name:</strong></p>
                    <p><?= $post["name"] ?></p>
                </div>
                <div class="mb-3">
                    <p class="mb-1"><strong>Post Category:</strong></p>
                    <a href="/admin/posts/categories/details?id=<?= $post["category_id"]; ?>"><?php echo PostCategoryController::getCategoryName($categories, $post["category_id"]) ?></a>
                </div>
                <div>
                    <p class="mb-1"><strong>Post Short Description:</strong></p>
                    <?= html_entity_decode($post["short_description"]) ?>
                </div>

            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-3"><strong>Post Image:</strong></p>
                    <img style="width:100%; max-width: 400px; height:400px; object-fit:cover" src="" alt="<?= $post["name"] ?>">
                </div>

            </div>

            <div class="col-12">
                <p class="mb-1"><strong>Post Description:</strong></p>
                <div class="bg-white p-3 border rounded">
                    <?= html_entity_decode($post["description"]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const deleteBtn = document.querySelector("#delete-btn")
    const alert = document.querySelector("#alert")

    deleteBtn.addEventListener("click", async (e) => {
        e.preventDefault()

        deleteBtn.classList.add("disabled")
        alert.classList.add("d-none")
        if (window.confirm("Delete this Product")) {
            const data = new FormData()
            data.append("id", <?= $post["id"] ?>)
            const response = await fetch("/admin/posts/delete", {
                method: "POST",
                body: data
            })
            const result = await response.json()
            alert.classList.remove("d-none")
            alert.innerText = result.message
            if (result.status == true) {
                alert.classList.add("alert-success")
                alert.classList.remove("alert-danger")
                window.location.href = "/admin/posts"
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