<?php

$orders = $data["data"]["orders"];
$users = $data["data"]["users"];


?>

<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800 flex-fill">Orders</h1>
  <a href="/admin/orders" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
    <i class="fas fa-plus fa-sm text-white-50"></i> Generate Report</a>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">All Orders</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Amount</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          foreach ($orders as $order) :
            $i++;
            $username = "Guest";
            if ($order["id"] != null) {
              foreach ($users as $user) {
                if ($user["id"] == $order["user_id"]) {
                  $username = $user["name"];
                }
              }
            }
          ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $username ?></td>
              <td><?= $order["amount"] ?></td>
              <td><?= $order["status"] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot>
          <tr>
            <th>#</th>
            <th>User</th>
            <th>Amount</th>
            <th>Status</th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>


<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/js/demo/datatables-demo.js"></script>
