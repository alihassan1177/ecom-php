<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">New Banner</h1>
</div>

<div id="alert" class="alert d-none" role="alert">
</div>

<div class="row col-md-8 mb-5">
    <form id="banner-form" enctype="multipart/form-data" style="gap:30px 0px" class="row">
        <div class="col-md-6">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>
        <div class="col-12">
            <label for="heading" class="form-label">Heading</label>
            <input name="heading" type="text" id="heading" class="form-control form-control-user">
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Sub Heading</label>
            <input type="text" class="form-control" name="sub-heading">
        </div>
        <div class="col-md-6">
            <label for="image" class="form-label">Button Text</label>
            <input type="text" class="form-control" name="btn-text">
        </div>
        <div class="col-12">
            <label for="image" class="form-label">Button Link</label>
            <input type="text" class="form-control" name="btn-link">
        </div>

        <div class="col">
            <button id="submit-btn" class="btn btn-primary">Add new Banner</button>
        </div>
    </form>

</div>

<script>

    const bannerForm = document.querySelector("#banner-form")
    const inputs = bannerForm.querySelectorAll(".form-control")
    const submitBtn = document.querySelector("#submit-btn")

    const alert = document.querySelector("#alert")

    submitBtn.addEventListener("click", async (e) => {
        alert.classList.add("d-none")
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

        const response = await fetch("/admin/banners/create", {
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
            window.location.href = "/admin/banners"
        } else {
            alert.classList.add("alert-danger")
            alert.classList.remove("alert-success")
        }

    })

    bannerForm.addEventListener("submit", (e) => {
        e.preventDefault()
    })
</script>