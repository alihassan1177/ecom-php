<?php

$results = $data["data"]["results"];
$query = $data["data"]["query"];

?>

<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Search Results for '<?= $query ?>'</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $placeholderImage = "/img/product-placeholder.png";
                    foreach ($results as $key => $items) :
                        if (count($items) > 0) :
                            foreach ($items as $item) :
                                $i++;
                    ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?php
                                        $name = $item["name"];
                                        $id = $item["id"];
                                        switch ($key) {
                                            case "categories":
                                                echo "<a href='/admin/products/categories/details?id=$id'>$name</a>";
                                                break;
                                            case "postCategories":
                                                echo "<a href='/admin/posts/categories/details?id=$id'>$name</a>";
                                                break;
                                            case "products":
                                                echo "<a href='/admin/products/details?id=$id'>$name</a>";
                                                break;
                                            case "posts":
                                                echo "<a href='/admin/posts/details?id=$id'>$name</a>";
                                                break;
                                            default:
                                                echo "<a href='#'>$name</a>";
                                                break;
                                        }

                                        ?></td>
                                    <td style="text-transform: capitalize;"><?= $key ?></td>
                                </tr>
                    <?php
                            endforeach;
                        endif;
                    endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Type</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>


<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/js/demo/datatables-demo.js"></script>