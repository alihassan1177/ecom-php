<?php

use App\controllers\Category;

$categories = $data["data"]["categories"];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">New Post Category</h1>
</div>

<div id="alert" class="alert d-none" role="alert">
</div>

<form id="category-form" method="POST" style="gap:30px" enctype="multipart/form-data" class="row">
    <div class="col-md-6">
        <label for="name" class="form-label">Category Name</label>
        <input name="name" type="text" id="name" class="form-control form-control-user">
    </div>
    <div class="col-md-6">
        <label for="parent" class="form-label">Parent Category</label>
        <select class="form-control" id="parent">
            <option value="0">None</option>
            <?php foreach ($categories as $category) :
                $fullCatname = Category::getCategoryName($categories, $category["id"]);
            ?>
                <option value="<?= $category["id"] ?>"><?= implode(Category::$categorySeprator, $fullCatname) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-12">
        <button id="submit-btn" class="btn btn-primary">Add new Category</button>
    </div>
</form>


<script>
    const submitBtn = document.querySelector("#submit-btn")
    const form = document.querySelector("#category-form")

    const alert = document.querySelector("#alert")

    const nameInp = document.querySelector("#name")
    const parentInp = document.querySelector("#parent")

    submitBtn.addEventListener("click", async (e) => {
        e.preventDefault()
        alert.classList.add("d-none")
        const data = new FormData()
        const input = {
            name: nameInp.value,
            parent: parentInp.value
        }
        data.append("name", input.name)
        data.append("parent", input.parent)

        const response = await fetch("/admin/posts/categories/create", {
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
        }
    })

    form.addEventListener("submit", (e) => {
        e.preventDefault()
    })
</script>