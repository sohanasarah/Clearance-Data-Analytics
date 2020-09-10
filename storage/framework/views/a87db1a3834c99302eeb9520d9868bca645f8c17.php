

<?php $__env->startSection('content-title'); ?>
Calendar Data
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-info float-right" href="javascript:void(0)" id="createNewCalendar"
                    style="margin-right: 5px;">
                    <i class="fas fa-plus"></i>
                    Create New
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card card-outline card-danger">
                    
                    <div class="card-body">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1%">#</th>
                                    <th>Calendar Year</th>
                                    <th>Calendar Period</th>
                                    <th>Month Name</th>
                                    <th>Fiscal Year</th>
                                    <th>Fiscal Period</th>
                                    <th>Status</th>
                                    <th>Expired</th>
                                    <th style="width: 20%" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=0;
                                ?>

                                <?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calendar_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo e($i); ?></td>
                                    <td><?php echo e($calendar_data->calendar_year); ?></td>
                                    <td><?php echo e($calendar_data->calendar_period); ?></td>
                                    <td><?php echo e($calendar_data->month_name); ?></td>
                                    <td><?php echo e($calendar_data->fiscal_year); ?></td>
                                    <td><?php echo e($calendar_data->fiscal_period); ?></td>
                                    <td class="project-state">
                                        <?php if($calendar_data->status == 'active'): ?>
                                        <span class="badge badge-success"><?php echo e($calendar_data->status); ?></span>
                                        <?php else: ?>
                                        <span class="badge badge-danger"><?php echo e($calendar_data->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="project-state">
                                        <?php if($calendar_data->expired == 'true'): ?>
                                        <span class="badge badge-warning"><?php echo e($calendar_data->expired); ?></span>
                                        <?php else: ?>
                                        <span class="badge badge-info"><?php echo e($calendar_data->expired); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info editCalendar" href="javascript:void(0)" data-id="<?php echo e($calendar_data->id); ?>">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger deleteCalendar" href="javascript:void(0)" data-id="<?php echo e($calendar_data->id); ?>">
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
                <form id="CalendarForm" name="CalendarForm" class="form-horizontal">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="calendar_id" id="calendar_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" id="year" name="year" placeholder="2020">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="period">Period</label>
                                <input type="text" class="form-control" id="period" name="period" placeholder="07">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="period">Month Name</label>
                                <input type="text" class="form-control" id="month_name" name="month_name"
                                    placeholder="Jul">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fiscal_year">Fiscal Year</label>
                                <input type="text" class="form-control" id="fiscal_year" name="fiscal_year"
                                    placeholder="2020-2021">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fiscal_period">Fiscal Period</label>
                                <input type="text" class="form-control" id="fiscal_period" name="fiscal_period"
                                    placeholder="01">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="expired">Expired</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="expired" id="expired1"
                                        value="true">
                                    <label class="form-check-label">True</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="expired" id="expired2"
                                        value="false" checked>
                                    <label class="form-check-label">False</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status1"
                                        value="active" checked>
                                    <label class="form-check-label">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="status2"
                                        value="inactive">
                                    <label class="form-check-label">Inactive</label>
                                </div>
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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
<script>
    $(function () {
        $("#myTable").DataTable({
            "responsive": true, "autoWidth": false, 
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#createNewCalendar').click(function () {
            $('#CalendarForm').trigger("reset");
            $('#modelHeading').html("Create New Calendar Data");
            $('#saveBtn').val("create-Calendar");
            $('#ajaxModel').modal('show');            
            $('#calendar_id').val('');
        });

        $('body').on('click', '.editCalendar', function () {
            var calendar_id = $(this).data('id');
            
            $.get("calendar" +'/' + calendar_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Calendar");
                $('#saveBtn').val("edit-Calendar");
                $('#ajaxModel').modal('show');

                $('#calendar_id').val(calendar_id);

                $('#year').val(data.calendar_year);
                $('#period').val(data.calendar_period);
                $('#fiscal_year').val(data.fiscal_year);
                $('#fiscal_period').val(data.fiscal_period);
                $('#month_name').val(data.month_name);
                $('#status').val(data.status);
                $('#expired').val(data.expired);
            })
        }); 

        //Submit Data
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#CalendarForm').serialize(),
                url: "",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('#CalendarForm').trigger("reset");
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

        $('body').on('click', '.deleteCalendar', function () {
            var calendar_id = $(this).data("id");

            confirm("Are You sure want to delete?");
                $.ajax({
                    type: "DELETE",
                    url: "calendar"+'/'+calendar_id,
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/master/calendar/index.blade.php ENDPATH**/ ?>