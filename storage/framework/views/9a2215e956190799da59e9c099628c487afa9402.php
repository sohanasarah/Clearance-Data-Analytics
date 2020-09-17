
<?php $__env->startSection('content-title'); ?>
Deposit Data
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-warning float-right" href="<?php echo e(asset('templates/deposit_file.csv')); ?>" 
                    style="margin-left: 5px;">
                    <i class="fas fa-file-download"></i>
                    Download Template
                </a>
                <a class="btn btn-info float-right" href="javascript:void(0)" id="uploadCSV">
                    <i class="fas fa-file-upload"></i>
                    Upload CSV
                </a>
                <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewDeposit"
                    style="margin-right: 5px;">
                    <i class="fas fa-plus"></i>
                    Create New
                </a>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card card-outline card-dark">
                    
                    <div class="card-body">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead>                                <tr>
                                    <th>ID</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Manufacturer</th>
                                    <th>Vat Deposit</th>
                                    <th>SD Deposit</th>
                                    <th>HDSC Deposit</th>
                                    <th style="width: 30%" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($deposit->calendar->id); ?></td>
                                    <td><?php echo e($deposit->calendar->calendar_year); ?></td>
                                    <td><?php echo e($deposit->calendar->month_name); ?></td>
                                    <td><?php echo e($deposit->manufacturer->short_name); ?></td>
                                    <td><?php echo e($deposit->vat_deposit); ?></td>
                                    <td><?php echo e($deposit->sd_deposit); ?></td>
                                    <td><?php echo e($deposit->hdsc_deposit); ?></td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm editDeposit" href="javascript:void(0)"
                                            data-id="<?php echo e($deposit->id); ?>">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm deleteDeposit" href="javascript:void(0)"
                                            data-id="<?php echo e($deposit->id); ?>">
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
                <form id="DepositForm" name="DepositForm" class="form-horizontal">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="deposit_id" id="deposit_id">
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
                                    <option selected disabled>Select Period</option>
                                    <?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendar_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($calendar_data->calendar_period); ?>">
                                        <?php echo e($calendar_data->calendar_period); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="manufacturer_id">Manufacturer</label>
                                <select class="form-control" id="manufacturer_id" name="manufacturer_id">
                                    <option selected disabled>Select Manufacturer</option>
                                    <?php $__currentLoopData = $manufacturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($manufacturer->id); ?>"><?php echo e($manufacturer->short_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="vat_deposit">VAT Deposit</label>
                                <input type="text" class="form-control" id="vat_deposit" name="vat_deposit"
                                    placeholder="VAT Deposit">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="sd_deposit">SD Deposit</label>
                                <input type="text" class="form-control" id="sd_deposit" name="sd_deposit"
                                    placeholder="SD Deposit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="hdsc_deposit">HDSC Deposit</label>
                                <input type="text" class="form-control" id="hdsc_deposit" name="hdsc_deposit"
                                    placeholder="HDSC Deposit">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
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
            "responsive": true, 
            "autoWidth": false,
            "dom": 'Blfrtip',
            "pagination": 'true',
            "buttons": [
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print',
                        
                    ]
                }

                ]         
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#createNewDeposit').click(function () {
            $('#DepositForm').trigger("reset");
            $('#modelHeading').html("Create New Deposit");
            $('#saveBtn').val("create-deposit");
            $('#ajaxModel').modal('show');            
            $('#deposit_id').val('');
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
                    url: "<?php echo e(route('deposit.import')); ?>",
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
                        console.log('errors:', data);
                        var errors = data.responseJSON.message;
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

        $('body').on('click', '.editDeposit', function () {
            
            var deposit_id = $(this).data('id');
            
            $.get("deposit" +'/' + deposit_id +'/edit', function (data) {
                console.log(data);

                $('#modelHeading').html("Edit Deposit");
                $('#saveBtn').val("edit-deposit");
                $('#ajaxModel').modal('show');

                $('#deposit_id').val(deposit_id);

                $('#year').val(data.calendar.calendar_year);
                $('#month').val(data.calendar.calendar_period);
                $('#manufacturer_id').val(data.manufacturer_id);
                $('#vat_deposit').val(data.vat_deposit);
                $('#sd_deposit').val(data.sd_deposit);
                $('#hdsc_deposit').val(data.hdsc_deposit);
            })
        }); 

        //Submit Data
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#DepositForm').serialize(),
                url: "",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('#DepositForm').trigger("reset");
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

        $('body').on('click', '.deleteDeposit', function () {
            var deposit_id = $(this).data("id");

            confirm("Are You sure want to delete?");
                $.ajax({
                    type: "DELETE",
                    url: "deposit"+'/'+deposit_id,
                    success: function (data) {
                        window.location.reload();
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/master/deposits/index.blade.php ENDPATH**/ ?>