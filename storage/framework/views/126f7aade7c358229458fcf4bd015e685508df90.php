

<?php $__env->startSection('content-title'); ?>
Segments Page
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Add Segments</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" id="requestForm">
                        <?php echo csrf_field(); ?>
                        <!-- <?php echo e(csrf_field()); ?> -->

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="alert alert-success print-success-msg"></div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="fullname">Internal Segment</label>
                                <input type="text" class="form-control" id="internal_segment">
                                
                            <div id='internal_seg_err'></div>
                        </div>
                        <div class="form-group">
                            <label for="shortname">External Segment 1</label>
                            <input type="text" class="form-control" id="external_segment1">
                            <?php if($errors->has('external_segment1')): ?>
                            <div class="error"><?php echo e($errors->first('external_segment1')); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="shortname">External Segment 2</label>
                            <input type="text" class="form-control" id="external_segment2">
                            <?php if($errors->has('external_segment2')): ?>
                            <div class="error"><?php echo e($errors->first('external_segment2')); ?></div>
                            <?php endif; ?>
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
                    <h3 class="card-title">Segment Database</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="myTable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Internal Segment</th>
                                <th>External Segment1</th>
                                <th>External Segment2</th>
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
                                <td><?php echo e($list_item->internal_segment); ?></td>
                                <td><?php echo e($list_item->external_segment1); ?></td>
                                <td><?php echo e($list_item->external_segment2); ?></td>
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
            "responsive": true
            , "autoWidth": false
        , });

        //Submit Data
        $("#submit").click(function(e) {
            e.preventDefault();
            $(".print-error-msg").hide();
            $(".print-success-msg").hide();

            $.ajax({
                url: "<?php echo e(route('segment.store')); ?>", 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    internal_segment: $("#internal_segment").val(),
                    external_segment1: $("#external_segment1").val(),
                    external_segment2: $("#external_segment2").val(),
                    status: $("#status").val(),
                },
                success: function(response) {
                    //console.log(response);
                    // if($.isEmptyObject(response.error)){
                        //$(".print-error-msg").hide();
                        $(".print-success-msg").html(response.message);
                       // $(".print-success-msg").fadeOut(2000);

                    //}
                    // else{
                    //     $(".print-error-msg").find("ul").html('');
                    //     $(".print-error-msg").css('display','block');
                    //     $.each( response.error, function( key, value ) {
                    //         $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                    //     });
                    // }

                },
                error: function(response){
                    console.log(response);
                    var errors = response.responseJSON;
                    console.log(errors);

                    $('#internal_seg_err').html('<p>'+ response.responseJSON.errors.internal_segment[0] + '</p>');
                }
            });
        });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/pages/segments.blade.php ENDPATH**/ ?>