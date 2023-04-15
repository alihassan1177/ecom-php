<?php

use App\ProductCategoryController;

$product = $data["data"]["product"];
$placeholderImage = "/img/product-placeholder.png";
$categories = $data["data"]["categories"];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Product Details</h1>
    <a href="/admin/products/edit?id=<?= $product["id"] ?>" class="d-none d-sm-inline-block btn mx-2 btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Edit Product</a>
    <a id="delete-btn" href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Delete Product</a>
</div>
<div id="alert" class="alert d-none"></div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Product Details</h6>
    </div>
    <div class="card-body">
        <div style="row-gap: 20px;" class="row flex-row-reverse">
            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-1"><strong>Product Name:</strong></p>
                    <p><?= $product["name"] ?></p>
                </div>
                <div class="mb-3">
                    <p class="mb-1"><strong>Product Category:</strong></p>
                    <a href="/admin/products/categories/details?id=<?= $product["category_id"]; ?>"><?php echo ProductCategoryController::getCategoryName($categories, $product["category_id"]) ?></a>
                </div>
                <div>
                    <p class="mb-1"><strong>Product Short Description:</strong></p>
                    <?= html_entity_decode($product["short_description"]) ?>
                </div>
                <div class="mb-3">
                    <p class="mb-1"><strong>Product Quantity:</strong></p>
                    <p><?= $product["quantity"] ?></p>
                </div>
                <div>
                    <p class="mb-1"><strong>Product Price:</strong></p>
                    <p><?= "$" . $product["quantity"] ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <p class="mb-3"><strong>Product Image:</strong></p>
                    <img style="width:100%; max-width: 400px; height:400px; object-fit:cover" src="<?php echo ($product["image"] != "") ? $product["image"] : $placeholderImage;  ?>" alt="<?= $product["name"] ?>">
                </div>

            </div>

            <div class="col-12">
                <p class="mb-1"><strong>Product Description:</strong></p>
                <div class="bg-white p-3 border rounded">
                    <?= html_entity_decode($product["description"]) ?>
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
            data.append("id", <?= $product["id"] ?>)
            const response = await fetch("/admin/products/delete", {
                method: "POST",
                body: data
            })
            const result = await response.json()
            alert.classList.remove("d-none")
            alert.innerText = result.message
            if (result.status == true) {
                alert.classList.add("alert-success")
                alert.classList.remove("alert-danger")
                window.location.href = "/admin/products"
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