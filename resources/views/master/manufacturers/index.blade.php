@extends('layouts.master')

@section('content-title')
Manufacturers
@endsection

@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewManufacturer">
                    <i class="fas fa-plus"></i>
                    Create New
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card card-outline card-info">
                    {{-- <div class="card-header">
                        <h3 class="card-title">Manufacturers</h3>
                    </div> --}}
                    <div class="card-body">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 1%">
                                        ID
                                    </th>
                                    <th style="width: 30%">
                                        Manufacturer Name
                                    </th>
                                    <th style="width: 20%">
                                        Short Name
                                    </th>
                                    <th style="width: 4%" class="text-center">
                                        Status
                                    </th>
                                    <th style="width: 20%" class="text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>                                @foreach ($list as $list_item)                                <tr>
                                    <td>{{$list_item->id}}</td>
                                    <td>{{$list_item->full_name}}</td>
                                    <td>{{$list_item->short_name}}</td>                                    
                                    <td class="project-state">
                                        @if ($list_item->status == 'active')
                                        <span class="badge badge-success">{{$list_item->status}}</span>
                                        @else                                        <span class="badge badge-danger">{{$list_item->status}}</span>
                                        @endif                                    </td>                                    
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm editManufacturer" href="javascript:void(0)" data-id="{{ $list_item->id }}">                                            <i class="fas fa-pencil-alt">                                            </i>                                        </a>
                                        <a class="btn btn-danger btn-sm deleteManufacturer" href="javascript:void(0)" data-id="{{ $list_item->id }}">                                            <i class="fas fa-trash">                                            </i>                                        </a>
                                    </td>
                                </tr>
                                @endforeach
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
                <form id="ManufacturerForm" name="ManufacturerForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="manufacturer_id" id="manufacturer_id" v>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Full Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                placeholder="Full Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Short Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="short_name" name="short_name"
                                placeholder="Short Name">
                        </div>
                    </div>

                    <div class="row ml-4">
                        <div class="col-12 ">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="status1" name="status" checked>
                                    <label class="form-check-label">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="status2" name="status">
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

@endsection

@section('page-script')
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

        $('#createNewManufacturer').click(function () {
            $('#saveBtn').val("create-Manufacturer");
            $('#manufacturer_id').val('');
            $('#ManufacturerForm').trigger("reset");
            $('#modelHeading').html("Create New Manufacturer");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editManufacturer', function () {
            var manufacturer_id = $(this).data('id');

            $.get("manufacturer" +'/' + manufacturer_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Manufacturer");
                $('#saveBtn').val("edit-Manufacturer");
                $('#ajaxModel').modal('show');

                $('#manufacturer_id').val(manufacturer_id);

                $('#full_name').val(data.full_name);
                $('#short_name').val(data.short_name);
                $('#status').val(data.status);
            })
        }); 

        //Submit Data
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#ManufacturerForm').serialize(),
                url: "",
                type: "POST",
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                    $('#ManufacturerForm').trigger("reset");
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

        $('body').on('click', '.deleteManufacturer', function () {
            var manufacturer_id = $(this).data("id");

            confirm("Are You sure want to delete?");
                $.ajax({
                    type: "DELETE",
                    url: "manufacturer"+'/'+manufacturer_id,
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
@endsection