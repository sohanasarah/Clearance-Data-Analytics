@extends('layouts.master')

@section('content-title')
Clearance Data
@endsection

@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
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
                    {{-- <div class="card-header">
                        <h3 class="card-title">clearances</h3>
                    </div> --}}
                    <div class="card-body p-0">
                        <table class="table table-striped table-hover data-table">
                            <thead>
                                <tr>
                                    <th style="width: 1%">
                                        #
                                    </th>
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
                                    <th style="width: 20%">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=0;
                                @endphp
                                @foreach ($clearance as $clearance_data)
                                @php
                                $i++;

                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$clearance_data->item->item_name}}</td>
                                    <td>{{$clearance_data->calendar->calendar_year}}</td>
                                    <td>{{$clearance_data->calendar->month_name}}</td>
                                    <td>{{$clearance_data->measure}}</td>
                                    <td>{{$clearance_data->figure}}</td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm editclearance" data-id="{{ $clearance_data->id }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm deleteclearance"
                                            data-id="{{ $clearance_data->id }}">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{-- laravel pagination --}}
                            {{ $clearance->links() }}
                        </div>
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
                    @csrf
                    <input type="hidden" name="clearance_id" id="clearance_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select class="form-control" id="year" name="year">
                                    <option selected disabled>Select Year</option>
                                    @foreach ($clearance as $clearance_data)
                                    <option value="{{ $clearance_data->calendar->calendar_year }}">{{ $clearance_data->calendar->calendar_year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select class="form-control" id="month" name="month">
                                    <option selected disabled>Select month</option>
                                    @foreach ($clearance as $clearance_data)
                                    <option value="{{ $clearance_data->calendar->calendar_period }}">{{ $clearance_data->calendar->month_name }}</option>
                                    @endforeach
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
                                    @foreach ($clearance as $clearance_data)
                                    <option value="{{$clearance_data->item->id}}">{{$clearance_data->item->item_name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="measure">Measure</label>
                                <input type="text" class="form-control" id="measure" name="measure"
                                    placeholder="Measure">

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

@endsection

@section('page-script')
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#ajaxModel').on('hidden.bs.modal', function () {
            location.reload();
        })

        $('#createNewClearance').click(function () {
            $('#ClearanceForm').trigger("reset");
            $('#modelHeading').html("Create New Clearance");
            $('#saveBtn').val("create-clearance");
            $('#ajaxModel').modal('show');            
            $('#clearance_id').val('');
        });

        $('body').on('click', '.editclearance', function () {
            var clearance_id = $(this).data('id');
            
            $.get("clearance" +'/' + clearance_id +'/edit', function (data) {
                $('#modelHeading').html("Edit clearance");
                $('#saveBtn').val("edit-clearance");
                $('#ajaxModel').modal('show');

                $('#clearance_id').val(clearance_id);
                $('#year').val(data.year);
                $('#month').val(data.month);
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
                    document.location.reload(true);
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
                        document.location.reload(true);
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