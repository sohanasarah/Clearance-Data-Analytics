

<?php $__env->startSection('content-title'); ?>
Brands
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewbrand"
                    style="margin-right: 5px;">
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
                                    <th style="width: 1%">#</th>
                                    <th>Brand</th>
                                    <th>Short Name</th>
                                    <th>Segment</th>
                                    <th>Manufacturer</th>
                                    <th>Status</th>
                                    <th style="width: 20%" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=0;
                                ?>
                                <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $i++;

                                ?>
                                <tr>
                                    <td><?php echo e($i); ?></td>
                                    <td><?php echo e($brand->brand_name); ?></td>
                                    <td><?php echo e($brand->short_name); ?></td>
                                    <td><?php echo e($brand->segment->internal_segment); ?></td>
                                    <td><?php echo e($brand->manufacturer->short_name); ?></td>
                                   
                                    <td class="project-state">
                                        <?php if($brand->status == 'active'): ?>
                                        <span class="badge badge-success"><?php echo e($brand->status); ?></span>
                                        <?php else: ?>
                                        <span class="badge badge-danger"><?php echo e($brand->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info editbrand" href="javascript:void(0)" data-id="<?php echo e($brand->id); ?>">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger deletebrand" href="javascript:void(0)" data-id="<?php echo e($brand->id); ?>">
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
                <form id="brandForm" name="brandForm" class="form-horizontal">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="brand_id" id="brand_id">

                    <div class="form-group">
                        <label for="brand_name">Brand Name</label>
                        <input type="text" class="form-control" id="brand_name" name="brand_name"
                            placeholder="Brand Name">

                    </div>
                    <div class="form-group">
                        <label for="short_name">Short Name</label>
                        <input type="text" class="form-control" id="short_name" name="short_name"
                            placeholder="Short Name">
                    </div>
                    <div class="form-group">
                        <label for="segment_id">Segment</label>
                        <select class="form-control" id="segment_id" name="segment_id">
                            <option selected disabled>Select Segment</option>
                            <?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($segment->id); ?>"><?php echo e($segment->internal_segment); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="manufacturer_id">Manufacturer</label>
                        <select class="form-control" id="manufacturer_id" name="manufacturer_id">
                            <option selected disabled>Select Manufacturer</option>
                            <?php $__currentLoopData = $manufacturers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($manufacturer->id); ?>"><?php echo e($manufacturer->short_name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
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
            "responsive": true, "autoWidth": false, 
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#createNewbrand').click(function () {
            $('#brandForm').trigger("reset");
            $('#modelHeading').html("Create New Brand");
            $('#saveBtn').val("create-brand");
            $('#ajaxModel').modal('show');            
            $('#brand_id').val('');
        });

        $('body').on('click', '.editbrand', function () {
            var brand_id = $(this).data('id');
            
            $.get("brand" +'/' + brand_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Brand");
                $('#saveBtn').val("edit-brand");
                $('#ajaxModel').modal('show');

                $('#brand_id').val(brand_id);

                $('#brand_name').val(data.brand_name);
                $('#short_name').val(data.short_name);
                $('#manufacturer_id').val(data.manufacturer_id);
                $('#segment_id').val(data.segment_id);
                $('#status').val(data.status);
            })
        }); 

        //Submit Data
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#brandForm').serialize(),
                url: "",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('#brandForm').trigger("reset");
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

        $('body').on('click', '.deletebrand', function () {
            var brand_id = $(this).data("id");

            confirm("Are You sure want to delete?");
                $.ajax({
                    type: "DELETE",
                    url: "brand"+'/'+brand_id,
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/master/brands/index.blade.php ENDPATH**/ ?>