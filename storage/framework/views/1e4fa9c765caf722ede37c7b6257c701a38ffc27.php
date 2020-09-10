<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Add New Brand</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form role="form" id="requestForm">
        <?php echo csrf_field(); ?>
        <!-- <?php echo e(csrf_field()); ?> -->

        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>

        <div class="alert alert-success print-success-msg" style="display:none">
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="brand_name">Brand Name</label>
                <input type="text" class="form-control" id="brand_name">
                
            </div>
            <div class="form-group">
                <label for="short_name">Short Name</label>
                <input type="text" class="form-control" id="short_name">
            </div>
            <div class="form-group">
                <label for="segment_id">Segment</label>
                <select class="form-control" id="segment_id">
                    <option selected disabled>Select status</option>
                    <option value="1">Premium</option>
                    
                </select>
            </div>
            <div class="form-group">
                <label for="manufacturer_id">Manufacturer</label>
                <select class="form-control" id="manufacturer_id">
                    <option selected disabled>Select status</option>
                    <option value="1">BATB</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status">
                    <option selected disabled>Select status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info" id="submit">Add</button>
        </div>
        <!-- /.card-footer -->
    </form>
</div>
<!-- /.card --><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/master/brands/create.blade.php ENDPATH**/ ?>