

<?php $__env->startSection('content-title'); ?>
Brands Page
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
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
                <!-- /.card -->

            </div>
            <!--/.col -->
            <div class="col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">All Brands</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Brands</th>
                                    <th>Short Name</th>
                                    <th>Segment</th>
                                    <th>Manufacturer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=0;
                                ?>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $i++;
                                ?>

                                <tr>
                                    <td><?php echo e($i); ?></td>
                                    <td><?php echo e($list_item->brand_name); ?></td>
                                    <td><?php echo e($list_item->short_name); ?></td>
                                    <td><?php echo e($list_item->manufacturer_id); ?></td>
                                    <td><?php echo e($list_item->segment_id); ?></td>
                                    <td><?php echo e($list_item->status); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--/.col -->
        </div>
        <!--/.row -->
    </div>
    <!--/.container -->
</div>
<!-- /.content -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
    $(function() {
        $("#myTable").DataTable({
            "responsive": true, "autoWidth": false, 
        });

        //Submit Data
        $("#submit").click(function(e) {
            e.preventDefault();
            $(".print-error-msg").hide();
            $(".print-success-msg").hide();

            $.ajax({
                url: "<?php echo e(route('brand.store')); ?>", 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    brand_name: $("#brand_name").val(),
                    short_name: $("#short_name").val(),
                    manufacturer_id: $("#manufacturer_id").val(),
                    segment_id: $("#segment_id").val(),
                    status: $("#status").val(),
                },
                success: function(response) {
                    console.log(response);
                    toastr.success(response.message);
                },
                error: function(response){
                    console.log(response.responseJSON.errors);
                    $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            toastr.error(value);
                    });
                }
            });
        });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/pages/brands.blade.php ENDPATH**/ ?>