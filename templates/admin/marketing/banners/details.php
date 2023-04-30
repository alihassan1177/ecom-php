<?php

$banner  = $data["data"]["banner"];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800 flex-fill">Banner Details</h1>
  <a href="/admin/banners/edit?id=<?= $banner["id"] ?>" class="d-none d-sm-inline-block btn mx-2 btn-sm btn-primary shadow-sm">
    <i class="fas fa-download fa-sm text-white-50"></i> Edit Banner</a>
  <a id="delete-btn" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
    <i class="fas fa-download fa-sm text-white-50"></i> Delete Banner</a>
</div>
<div id="alert" class="alert d-none"></div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Banner Preview</h6>
  </div>
  <div class="card-body">
    <div id="header-carousel" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="img-fluid" src="<?= $banner["image"] ?>" alt="Image">
          <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
            <div class="p-3" style="max-width: 700px;">
              <h4 class="text-light text-uppercase font-weight-medium mb-3"><?= html_entity_decode($banner["sub_heading"])  ?></h4>
              <h3 class="display-4 text-white font-weight-semi-bold mb-4"><?= html_entity_decode($banner["heading"])  ?></h3>
              <a href="<?= html_entity_decode($banner["btn_link"])  ?>" class="btn btn-light py-2 px-3"><?= html_entity_decode($banner["btn_text"])  ?></a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<style>
  .carousel-caption {
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    background: rgba(0, 0, 0, 0.3) !important;
    z-index: 1 !important;
  }
</style>

<script>
    const deleteBtn = document.querySelector("#delete-btn")
    const alert = document.querySelector("#alert")

    deleteBtn.addEventListener("click", async (e) => {
        e.preventDefault()

        deleteBtn.classList.add("disabled")
        alert.classList.add("d-none")
        if (window.confirm("Delete this Banner")) {
            const data = new FormData()
            data.append("id", <?= $banner["id"] ?>)
            const response = await fetch("/admin/banners/delete", {
                method: "POST",
                body: data
            })
            const result = await response.json()
            alert.classList.remove("d-none")
            alert.innerText = result.message
            if (result.status == true) {
                alert.classList.add("alert-success")
                alert.classList.remove("alert-danger")
                window.location.href = "/admin/banners"
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
