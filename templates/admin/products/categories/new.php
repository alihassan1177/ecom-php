<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">New Product Category</h1>
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
        </select>
    </div>
    <div class="col-md-6">
        <label for="image" class="form-label">Category Image</label>
        <input type="file" class="form-control" name="image" id="image">
    </div>
    <div class="col-12">
        <button id="submit-btn" class="btn btn-primary">Add new Category</button>
    </div>
</form>


<script>

    const submitBtn = document.querySelector("#submit-btn")
    const form = document.querySelector("#category-form")

    const nameInp = document.querySelector("#name")
    const parentInp = document.querySelector("#parent")
    const imgInp = document.querySelector("#image")

    submitBtn.addEventListener("click", async(e)=>{
        e.preventDefault()
        const data = new FormData()
        const input = {
            name : nameInp.value,
            parent : parentInp.value,
            image : imgInp.files[0]
        }
        data.append("name", input.name)
        data.append("parent", input.parent)
        data.append("image", input.image)

        const response = await fetch("/admin/products/categories/create", {
            method : "POST",
            body : data
        })
        const result = await response.text()
        console.log(result)
    })

    form.addEventListener("submit", (e)=>{
        e.preventDefault()
    })

</script>