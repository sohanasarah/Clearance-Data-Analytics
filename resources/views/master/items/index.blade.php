@extends('layouts.master')

@section('content-title')
Item Master
@endsection

@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-warning float-right" href="{{ asset('templates/items_file.csv') }}"
                    style="margin-left: 5px;">
                    <i class="fas fa-file-download"></i>
                    Download Template
                </a>
                <a class="btn btn-success float-right" href="javascript:void(0)" id="uploadCSV">
                    <i class="fas fa-file-upload"></i>
                    Upload CSV
                </a>
                <a class="btn btn-primary float-right" href="javascript:void(0)" id="createNewItem"
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
                    {{-- <div class="card-header">
                        <h3 class="card-title">clearances</h3>
                    </div> --}}
                    <div class="card-body">
                        <table id="myTable" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                    <th style="width: 20%" class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->item_code}}</td>
                                    <td>{{$item->item_name}}</td>
                                    <td>{{$item->brand->brand_name}}</td>
                                    <td class="project-state">
                                        @if ($item->status == 'active')
                                        <span class="badge badge-success">{{$item->status}}</span>
                                        @else
                                        <span class="badge badge-danger">{{ $item->status }}</span>
                                        @endif
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info editItem" href="javascript:void(0)"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger deleteItem" href="javascript:void(0)"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <div class="d-flex justify-content-center">
                            {{-- laravel pagination --}}
                        {{-- {{ $items->links() }} --}}
                        {{-- </div> --}}
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
                    @csrf
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
                                    @foreach ($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @endforeach
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
                    @csrf
                    <input type="file" name="import_file" id="import_file" class="form-control">
                    <br>
                    <button class="btn btn-success" id="uploadBtn">Upload</button>
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

        $('#createNewItem').click(function () {
            $('#ItemForm').trigger("reset");
            $('#modelHeading').html("Create New Item");
            $('#saveBtn').val("create-item");
            $('#ajaxModel').modal('show');            
            $('#item_id').val('');
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
                    url: "{{ route('item.import') }}",
                    type: "POST",
                    dataType: "json",
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
@endsection