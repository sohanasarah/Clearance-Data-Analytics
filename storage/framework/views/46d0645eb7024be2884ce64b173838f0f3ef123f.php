

<?php $__env->startSection('content-title'); ?>
Segments
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-info float-right" href="javascript:void(0)" id="createNewSegment">
                    <i class="fas fa-plus"></i>
                    Create New
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card card-outline card-success">
                    
                    <div class="card-body">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1%">
                                        ID
                                    </th>
                                    <th style="width: 30%">
                                        Internal Segment
                                    </th>
                                    <th style="width: 20%">
                                        External Segment 1
                                    </th>
                                    <th style="width: 20%">
                                        External Segment 2
                                    </th>
                                    <th style="width: 4%" class="text-center">
                                        Status
                                    </th>
                                    <th style="width: 20%" class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                <tr>                                    <td><?php echo e($list_item->id); ?></td>
                                    <td><?php echo e($list_item->internal_segment); ?></td>
                                    <td><?php echo e($list_item->external_segment1); ?></td>
                                    <td><?php echo e($list_item->external_segment2); ?></td>
                                    <td class="project-state">
                                        <?php if($list_item->status == 'active'): ?>
                                        <span class="badge badge-success"><?php echo e($list_item->status); ?></span>
                                        <?php else: ?>
                                        <span class="badge badge-danger"><?php echo e($list_item->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info editSegment" href="javascript:void(0)" data-id="<?php echo e($list_item->id); ?>">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger deleteSegment" href="javascript:void(0)" data-id="<?php echo e($list_item->id); ?>">
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
                <form id="SegmentForm" name="SegmentForm" class="form-horizontal">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="segment_id" id="segment_id">

                    <div class="form-group">
                        <label for="internal_segment">Internal Segment</label>
                        <input type="text" class="form-control" id="internal_segment" name="internal_segment">
                    </div>

                    <div class="form-group">
                        <label for="external_segment1">External Segment 1</label>
                        <input type="text" class="form-control" id="external_segment1" name="external_segment1">

                    </div>
                    <div class="form-group">
                        <label for="external_segment2">External Segment 2</label>
                        <input type="text" class="form-control" id="external_segment2" name="external_segment2">

                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status1" value="active" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="status2" value="inactive">
                            <label class="form-check-label">Inactive</label>
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

        $('#createNewSegment').click(function () {
            $('#SegmentForm').trigger("reset");
            $('#modelHeading').html("Create New Segment");
            $('#saveBtn').val("create-Segment");
            $('#ajaxModel').modal('show');            
            $('#segment_id').val('');
        });

        $('body').on('click', '.editSegment', function () {
            var segment_id = $(this).data('id');
            
            $.get("segment" +'/' + segment_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Segment");
                $('#saveBtn').val("edit-Segment");
                $('#ajaxModel').modal('show');

                $('#segment_id').val(segment_id);

                $('#internal_segment').val(data.internal_segment);
                $('#external_segment1').val(data.external_segment1);
                $('#external_segment2').val(data.external_segment2);
                $('#status').val(data.status);
            })
        }); 

        //Submit Data
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#SegmentForm').serialize(),
                url: "",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('#SegmentForm').trigger("reset");
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

        $('body').on('click', '.deleteSegment', function () {
            var segment_id = $(this).data("id");

            confirm("Are You sure want to delete?");
                $.ajax({
                    type: "DELETE",
                    url: "segment"+'/'+segment_id,
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/master/segments/index.blade.php ENDPATH**/ ?>