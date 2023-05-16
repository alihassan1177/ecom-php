<?php

use App\controllers\Category;

$categories = $data["data"]["categories"];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">New Post</h1>
</div>

<div id="alert" class="alert d-none" role="alert">
</div>

<form id="post-form" method="POST" style="gap:30px;" enctype="multipart/form-data" class="row mb-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Post Name</label>
        <input name="name" type="text" id="name" class="form-control form-control-user">
    </div>
    <div class="col-md-6">
        <label for="parent" class="form-label">Post Category</label>
        <select name="category_id" class="form-control" id="parent">
            <option value="0">Uncategorized</option>
            <?php foreach ($categories as $category) :
                $fullCatname = Category::getCategoryName($categories, $category["id"]);
            ?>

                <option value="<?= $category["id"] ?>"><?php echo implode(Category::$categorySeprator, $fullCatname); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="parent" class="form-label">Post Featured Image</label>
        <input type="file" name="image" class="form-control">
    </div>
    <div class="col-md-6">
        <label for="parent" class="form-label">Post Short Description</label>
        <textarea name="short_description" class="form-control" cols="30" rows="5"></textarea>
    </div>
    <div class="col-md-6">
        <label for="parent" class="form-label">Post Details</label>
        <div class="summernote"></div>
    </div>
    <div class="col-12">
        <button id="submit-btn" class="btn btn-primary">Add new Post</button>
    </div>
</form>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<style>
    .panel-heading.note-toolbar {
        border-bottom: 1px solid rgba(0, 0, 0, 0.2)
    }

    .note-editable {
        background-color: white;
        min-height: 700px;
    }
</style>


<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });

    const postForm = document.querySelector("#post-form")
    const inputs = postForm.querySelectorAll(".form-control")
    const submitBtn = document.querySelector("#submit-btn")

    const alert = document.querySelector("#alert")

    submitBtn.addEventListener("click", async (e) => {
        alert.classList.add("d-none")
        const summerNote = document.querySelector(".note-editable")
        e.preventDefault()
        const formData = new FormData()
        inputs.forEach(input => {
            console.log(input.type)
            if (input.type == "file") {
                formData.append(input.name, input.files[0])
            } else {
                formData.append(input.name, input.value)
            }
        })
        formData.append("description", summerNote.innerHTML.toString())

        const response = await fetch("/admin/posts/create", {
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
            window.location.href = "/admin/posts"
        } else {
            alert.classList.add("alert-danger")
            alert.classList.remove("alert-success")
        }

    })

    postForm.addEventListener("submit", (e) => {
        e.preventDefault()
    })
</script>