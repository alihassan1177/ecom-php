<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">Categories</h1>
    <a href="/admin/posts" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
        <i class="fas fa-download fa-sm text-white-50"></i> Posts</a>
    <a href="/admin/posts/categories/new" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Add new Category</a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">All Categories</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="category-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Post Quantity</th>
                    </tr>
                </thead>
                <tbody>

                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Post Quantity</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category-table').DataTable();
    });
</script>