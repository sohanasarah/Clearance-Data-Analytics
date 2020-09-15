

<?php $__env->startSection('content-title'); ?>
Clearance Data
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-warning float-right" href="<?php echo e(asset('templates/clearance_file.csv')); ?>"
                    style="margin-left: 5px;">
                    <i class="fas fa-file-download"></i>
                    Download Template
                </a>
                <a class="btn btn-primary float-right" href="javascript:void(0)" id="uploadCSV">
                    <i class="fas fa-file-upload"></i>
                    Upload CSV
                </a>
                <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewClearance"
                    style="margin-right: 5px;">
                    <i class="fas fa-plus"></i>
                    Create New
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card card-outline card-warning">
                    
                    <div class="card-body">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>
                                        SKU
                                    </th>
                                    <th>
                                        Year
                                    </th>
                                    <th>
                                        Month
                                    </th>
                                    <th>
                                        Measure
                                    </th>
                                    <th>
                                        Figure
                                    </th>
                                    <th style="width: 20%" class="text-right">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $clearance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clearance_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($clearance_data->id); ?></td>
                                    <td><?php echo e($clearance_data->item->item_name); ?></td>
                                    <td><?php echo e($clearance_data->calendar->calendar_year); ?></td>
                                    <td><?php echo e($clearance_data->calendar->month_name); ?></td>
                                    <td><?php echo e($clearance_data->measure); ?></td>
                                    <td><?php echo e($clearance_data->figure); ?></td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm editclearance" href="javascript:void(0)"
                                            data-id="<?php echo e($clearance_data->id); ?>">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm deleteclearance" href="javascript:void(0)"
                                            data-id="<?php echo e($clearance_data->id); ?>">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</div>



<!--MODAL-->
<div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ClearanceForm" name="ClearanceForm" class="form-horizontal">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="clearance_id" id="clearance_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php
                                $distinct_calendar = $calendar->unique('calendar_year');
                                ?>

                                <label for="year">Year</label>
                                <select class="form-control" id="year" name="year">
                                    <option selected disabled>Select Year</option>
                                    <?php $__currentLoopData = $distinct_calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendar_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($calendar_data->calendar_year); ?>">
                                        <?php echo e($calendar_data->calendar_year); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select class="form-control" id="month" name="month">
                                    <option selected disabled>Select month</option>
                                    <?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendar_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($calendar_data->calendar_period); ?>">
                                        <?php echo e($calendar_data->calendar_period); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="item_id">Item</label>
                                <select class="form-control" id="item_id" name="item_id">
                                    <option selected disabled>Select Item</option>
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->item_name); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="measure">Measure</label>
                                <select class="form-control" id="measure" name="measure">
                                    <option selected disabled>Select Measure</option>
                                    <?php $__currentLoopData = $codes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($code->code_value); ?>"><?php echo e($code->comments); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="figure">Figure</label>
                                <input type="text" class="form-control" id="figure" name="figure" placeholder="Figure">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--MODAL CSV UPLOAD-->
<div class="modal fade" id="ajaxModel2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title">CSV Upload</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="help-block">
            </div>
            <div class="modal-body">
                <form id="file_upload" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="file" name="import_file" id="import_file" class="form-control">
                    <br>
                    <button class="btn btn-success" id="uploadBtn">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
    $(function () {
        $("#myTable").DataTable({
            "responsive": true, "autoWidth": false,  "order": [[ 0, "desc" ]]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#createNewClearance').click(function () {
            $('#ClearanceForm').trigger("reset");
            $('#modelHeading').html("Create New Clearance");
            $('#saveBtn').val("create-clearance");
            $('#ajaxModel').modal('show');            
            $('#clearance_id').val('');
        });

        $('#uploadCSV').click(function () {
            $('#file_upload').trigger("reset");
            $('#uploadBtn').val("upload-file");
            $('#ajaxModel2').modal('show');

        });

        $('#uploadBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Uploading..');

            var fileInput = $('input[type=file]')[0].files[0];
            var formData = new FormData();
            formData.append('import_file', fileInput);
            //console.log(formData.get('import_file'));

            if(fileInput){
                $.ajax({
                    url: "<?php echo e(route('clearance.import')); ?>",
                    type: "POST",
                    dataType: 'json',
                    cache : false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        window.location.reload();
                        toastr.success(response.success);
                    },
                    error: function (data) {
                        var errors = data.responseJSON.message;
                        console.log(errors);

                        errorsHtml = '<div class="alert alert-danger"><strong>Errors:</strong><ul>';
                        $.each( errors, function( key, value ) {
                            errorsHtml += '<li>' + value + '</li>'; //showing only the first error.
                        });
                        errorsHtml += '</ul></div>';
                            
                        $('#help-block').html(errorsHtml);
                        $('#uploadBtn').html('Upload');
                    }
                });
            }else{
                errorsHtml = '<div class="alert alert-danger"><strong>Errors:</strong> No File Selected <d/iv>';
                $('#help-block').html(errorsHtml);
                $('#uploadBtn').html('Upload');
            }
            
        });

        $('body').on('click', '.editclearance', function () {
            var clearance_id = $(this).data('id');
            
            $.get("clearance" +'/' + clearance_id +'/edit', function (data) {
                $('#modelHeading').html("Edit clearance");
                $('#saveBtn').val("edit-clearance");
                $('#ajaxModel').modal('show');

                $('#clearance_id').val(clearance_id);
                
                $('#year').val(data.calendar.calendar_year);
                $('#month').val(data.calendar.calendar_period);
                $('#item_id').val(data.item_id);
                $('#measure').val(data.measure);
                $('#figure').val(data.figure);
            })
        }); 

        //Submit Data
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#ClearanceForm').serialize(),
                url: "",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('#ClearanceForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    window.location.reload();
                    toastr.success(response.message);
 
                },
                error: function (data) {
                    console.log('Error:', data);
                    alert(data.responseJSON.errors);
                    $('#saveBtn').html('Save Changes');
                }
            });
        
        });

        $('body').on('click', '.deleteclearance', function () {
            var clearance_id = $(this).data("id");

            confirm("Are You sure want to delete?");
                $.ajax({
                    type: "DELETE",
                    url: "clearance"+'/'+clearance_id,
                    success: function (data) {
                        window.location.reload()
                        toastr.error(data.message);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        alert(data.responseJSON.errors);
                    }
                });
            });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/master/clearance/index.blade.php ENDPATH**/ ?>