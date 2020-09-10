

<?php $__env->startSection('content-title'); ?>
Item Master
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-body'); ?>
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-warning float-right" href="javascript:void(0)" id="createNewItem"
                    style="margin-right: 5px;">
                    <i class="fas fa-plus"></i>
                    Create New Item
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card card-outline card-secondary">
                    
                    <div class="card-body">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1%">#</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                    <th style="width: 20%" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=0;
                                ?>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $i++;

                                ?>
                                <tr>
                                    <td><?php echo e($i); ?></td>
                                    <td><?php echo e($item->item_code); ?></td>
                                    <td><?php echo e($item->item_name); ?></td>
                                    <td><?php echo e($item->brand->brand_name); ?></td>
                                    <td class="project-state">
                                        <?php if($item->status == 'active'): ?>
                                        <span class="badge badge-success"><?php echo e($item->status); ?></span>
                                        <?php else: ?>
                                        <span class="badge badge-danger"><?php echo e($item->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info editItem" href="javascript:void(0)" data-id="<?php echo e($item->id); ?>">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger deleteItem" href="javascript:void(0)" data-id="<?php echo e($item->id); ?>">
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
                <form id="ItemForm" name="ItemForm" class="form-horizontal">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="item_id" id="item_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_code">Item Code</label>
                                <input type="text" class="form-control" id="item_code" name="item_code"
                                    placeholder="Item Code">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="item_name">Item Name</label>
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    placeholder="Item Name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="brand_id">Brands</label>
                                <select class="form-control" id="brand_id" name="brand_id">
                                    <option selected disabled>Select A Brand</option>
                                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->brand_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
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

        $('#createNewItem').click(function () {
            $('#ItemForm').trigger("reset");
            $('#modelHeading').html("Create New Item");
            $('#saveBtn').val("create-item");
            $('#ajaxModel').modal('show');            
            $('#item_id').val('');
        });

        $('body').on('click', '.editItem', function () {
            var item_id = $(this).data('id');
            
            $.get("item" +'/' + item_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Item");
                $('#saveBtn').val("edit-item");
                $('#ajaxModel').modal('show');

                $('#item_id').val(item_id);

                $('#item_code').val(data.item_code);
                $('#item_name').val(data.item_name);
                $('#brand_id').val(data.brand_id);
                $('#status').val(data.status);
            })
        }); 

        //Submit Data
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#ItemForm').serialize(),
                url: "",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('#ItemForm').trigger("reset");
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

        $('body').on('click', '.deleteItem', function () {
            var item_id = $(this).data("id");

            confirm("Are You sure want to delete?");
                $.ajax({
                    type: "DELETE",
                    url: "item"+'/'+item_id,
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/master/items/index.blade.php ENDPATH**/ ?>