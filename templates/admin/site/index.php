<?php

$placeholderImage = "/img/product-placeholder.png";
$placeholderFavicon = "/assets/images/fav-icon.png";
$settings = $data["data"]["settings"];

?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800 flex-fill">Site Settings</h1>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Site Settings</h6>
  </div>
  <div class="card-body">
      <div style="row-gap: 30px;" class="row">
        <div class="col-md-3">
        <label class="form-label">Site Logo</label>
        <img style="max-width: 300px;" class="d-block w-100" src="<?= $placeholderImage ?>" alt="Site Logo">          
        <input type="file" class="form-control" >  
      </div>
        <div class="col-md-3">
          <label class="form-label">Site Favicon</label>
          <img style="max-width: 200px;" class="d-block w-100" src="<?= $placeholderFavicon ?>" alt="Site Logo">          
          <input type="file"  class="form-control" >
        </div>
        <div class="col-md-4">
        </div>
        <div class="col-12">
          <label class="form-label">Site Title</label>
          <input value="<?= $settings["name"] ?>" type="text" class="form-control col-md-6">
        </div>
        <div class="col-12">
          <label class="form-label">Site Description</label>
          <textarea class="form-control col-md-6" cols="30" rows="10"></textarea>
        </div>
        
        <div class="col-12">
          <button class="btn btn-primary">Update Details</button>
        </div>
      </div>
  </div>
</div>
