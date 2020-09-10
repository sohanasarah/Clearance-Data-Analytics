

<?php $__env->startSection('content-title'); ?>
Manufacturer Page
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Add Manufacturer</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" method="POST">

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="alert alert-success print-success-msg" style="display:none">
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="fullname">Manufacturer Name</label>
                                <input type="text" class="form-control" id="full_name" placeholder="Full Name">
                                <?php if($errors->has('full_name')): ?>
                                <div class="error"><?php echo e($errors->first('full_name')); ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="shortname">Short Name</label>
                                <input type="text" class="form-control" id="short_name" placeholder="Short Name">
                                <?php if($errors->has('short_name')): ?>
                                <div class="error"><?php echo e($errors->first('short_name')); ?></div>
                                <?php endif; ?>
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
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">CSV Upload</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col -->
            <div class="col-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">All Manufacturers</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Manufacturer Name</th>
                                    <th>Short Name</th>
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
                                    <td><?php echo e($list_item->full_name); ?></td>
                                    <td><?php echo e($list_item->short_name); ?></td>
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

            var short_name = $("#short_name").val();
            var full_name = $("#full_name").val();
            var url = '<?php echo e(route('manufacturer.store')); ?>';

            $.ajax({
                url: url, 
                type: 'POST', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    short_name: short_name, 
                    full_name: full_name
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/pages/manufacturers.blade.php ENDPATH**/ ?>