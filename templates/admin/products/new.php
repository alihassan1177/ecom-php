<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 flex-fill">New Product</h1>
</div>
<div class="row col-md-8 mb-5">
<form style="gap:30px 0px" class="row">
    <div class="col-12">
        <label for="name" class="form-label">Product Name</label>
        <input name="name" type="text" id="name" class="form-control form-control-user">
    </div>
    <div class="col-md-6">
        <label for="parent" class="form-label">Product Category</label>
        <select class="form-control" name="parent">
            <option value="1">Uncategorized</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="image" class="form-label">Product Image</label>
        <input type="file" class="form-control" name="image" id="image">
    </div>
    <div class="col-md-6">
        <label for="image" class="form-label">Product Quantity</label>
        <input type="number" class="form-control" name="image" id="image">
    </div>
    <div class="col-md-6">
        <label for="image" class="form-label">Product Price</label>
        <input type="number" class="form-control" name="image" id="image">
    </div>
    <div class="col-12">
        <label for="image" class="form-label">Product Short Description</label>
        <textarea class="form-control" cols="30" rows="5"></textarea>
    </div>
    <div class="col-12">
        <label for="image" class="form-label">Product Description</label>
        <div class="summernote"></div>
    </div>
    <div class="col">
        <button class="btn btn-primary">Add new Product</button>
    </div>
</form>

</div>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<style>
    .panel-heading.note-toolbar{
        border-bottom:1px solid rgba(0,0,0,0.2)
    }
    .note-editable{
        background-color: white;
        min-height: 400px;
    }
</style>

<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
</script>