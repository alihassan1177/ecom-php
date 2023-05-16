<?php

use App\controllers\Category;

$product = $data["data"]["product"][0];
$categories = $data["data"]["categories"];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Edit Product : <?= $product["name"] ?> </h1>
</div>

<div id="alert" class="alert d-none" role="alert">
</div>

<div class="row col-md-8 mb-5">
    <form id="product-form" enctype="multipart/form-data" style="gap:30px 0px" class="row">
        <div class="col-12">
            <label for="name" class="form-label">Product Name</label>
            <input name="name" type="text" id="name" value="<?= $product["name"] ?>" class="form-control form-control-user">
        </div>
        <div class="col-md-6">
            <label for="parent" class="form-label">Product Category</label>
            <select class="form-control" name="category_id">
                <option <?php echo $product["category_id"] == 0 ? "selected" : "" ?> value="0">Uncategorized</option>
                <?php
                foreach ($categories as $data) {
                    $categoryID = $data["id"];
                    $fullCatname = Category::getCategoryName($categories, $categoryID);
                    $categoryName = implode(Category::$categorySeprator, $fullCatname);

                    if ($product["category_id"] == $data["id"]) {
                        echo "<option selected value='$categoryID'>$categoryName</option>";
                    } else {
                        echo "<option value='$categoryID'>$categoryName</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Product Image</label>
            <?php

            if ($product["image"] != "") {
                $path = $product["image"];
                $name = $product["name"];
                echo "<img src='$path' alt='$name' />";
            } else {
                echo "<p class='text-danger'>Product has no Image</p>";
            }

            ?>
            <input type="file" class="form-control" name="image" id="image">
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Product Quantity</label>
            <input type="number" class="form-control" value="<?= $product["quantity"] ?>" name="quantity" id="image">
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Product Price</label>
            <input type="number" class="form-control" value="<?= $product["price"] ?>" name="price" id="image">
        </div>
        <div class="col-12">
            <label for="image" class="form-label">Product Short Description</label>
            <textarea class="form-control" cols="30" rows="5" name="short_description"><?= $product["short_description"] ?></textarea>
        </div>
        <div class="col-12">
            <label for="image" class="form-label">Product Description</label>
            <div id="description" class="summernote"></div>
        </div>
        <div class="col">
            <button id="submit-btn" class="btn btn-primary">Update Product</button>
        </div>
    </form>

</div>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<style>
    .panel-heading.note-toolbar {
        border-bottom: 1px solid rgba(0, 0, 0, 0.2)
    }

    .note-editable {
        background-color: white;
        min-height: 400px;
    }
</style>

<script>
    $(document).ready(function() {
        $('.summernote').summernote();
        $('.note-editable').html("<?= html_entity_decode($product["description"]) ?>");
    });


    const productForm = document.querySelector("#product-form")
    const inputs = productForm.querySelectorAll(".form-control")
    const submitBtn = document.querySelector("#submit-btn")

    const alert = document.querySelector("#alert")


    submitBtn.addEventListener("click", async (e) => {
        alert.classList.add("d-none")
        e.preventDefault()
        const summerNote = document.querySelector(".note-editable")
        const formData = new FormData()
        inputs.forEach(input => {
            if (input.type == "file") {
                formData.append(input.name, input.files[0])
            } else {
                formData.append(input.name, input.value)
            }
        })
        formData.append("id", <?= $product["id"] ?>)
        formData.append("description", summerNote.innerHTML.toString())

        const response = await fetch("/admin/products/update", {
            method: "POST",
            body: formData
        })

        const result = await response.json()
        console.log(result)
        alert.classList.remove("d-none")
        alert.innerText = result.message
        if (result.status == true) {
            alert.classList.add("alert-success")
            alert.classList.remove("alert-danger")
            window.location.href = "/admin/products"
        } else {
            alert.classList.add("alert-danger")
            alert.classList.remove("alert-success")
        }

    })

    productForm.addEventListener("submit", (e) => {
        e.preventDefault()
    })
</script>