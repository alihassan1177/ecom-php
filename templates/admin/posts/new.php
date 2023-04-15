<?php

$categories = $data["data"]["categories"];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">New Post</h1>
</div>

<div id="alert" class="alert d-none" role="alert">
</div>

<form id="category-form" method="POST" style="gap:30px;" enctype="multipart/form-data" class="row mb-3">
    <div class="col-md-6">
        <label for="name" class="form-label">Post Name</label>
        <input name="name" type="text" id="name" class="form-control form-control-user">
    </div>
    <div class="col-md-6">
        <label for="parent" class="form-label">Post Category</label>
        <select class="form-control" id="parent">
            <option value="0">Uncategorized</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="parent" class="form-label">Post Featured Image</label>
        <input type="file" class="form-control" name="" id="">
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

    const submitBtn = document.querySelector("#submit-btn")
    const form = document.querySelector("#category-form")

    const alert = document.querySelector("#alert")

    const nameInp = document.querySelector("#name")
    const parentInp = document.querySelector("#parent")
    const imgInp = document.querySelector("#image")

    submitBtn.addEventListener("click", async (e) => {
        e.preventDefault()
        // alert.classList.add("d-none")
        // const data = new FormData()
        // const input = {
        //     name: nameInp.value,
        //     parent: parentInp.value,
        //     image: imgInp.files[0]
        // }
        // data.append("name", input.name)
        // data.append("parent", input.parent)
        // data.append("image", input.image)

        // const response = await fetch("/admin/products/categories/create", {
        //     method: "POST",
        //     body: data
        // })
        // const result = await response.json()
        // alert.classList.remove("d-none")
        // alert.innerText = result.message
        // if (result.status == true) {
        //     alert.classList.add("alert-success")
        //     alert.classList.remove("alert-danger")
        //     window.location.href = "/admin/products/categories"
        // } else {
        //     alert.classList.add("alert-danger")
        //     alert.classList.remove("alert-success")
        // }
    })

    form.addEventListener("submit", (e) => {
        e.preventDefault()
    })
</script>