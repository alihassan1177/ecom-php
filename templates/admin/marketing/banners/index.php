<?php

$banners = $data["data"]["banners"];

?>

<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800 flex-fill">Banners</h1>
  <a href="/admin/banners/new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> Add new Banner</a>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">All Banners</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Heading</th>
            <th>Sub Heading</th>
            <th>Button Text</th>
            <th>Button Link</th>
            <th>Image</th>

          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          foreach ($banners as $banner) :
            $i++;
          ?>
            <tr>
              <td><?= $i ?></td>
              <td> <a href="/admin/banners/details?id=<?= $banner["id"] ?>"><?= $banner["heading"] ?></a> </td>
              <td><?= $banner["sub_heading"] ?></td>
              <td><?= $banner["btn_text"] ?></td>
              <td><?= $banner["btn_link"] ?></td>
              <td><?= $banner["image"] ?></td>

            </tr>

          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>Heading</th>
            <th>Sub Heading</th>
            <th>Button Text</th>
            <th>Button Link</th>
            <th>Image</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>


<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/js/demo/datatables-demo.js"></script>
