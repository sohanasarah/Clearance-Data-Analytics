@extends('layouts.master')
@section('content-title')
Deposit Data
@endsection
@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <a class="btn btn-warning float-right" href="{{ asset('templates/deposit_file.csv') }}" 
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
                    {{-- <div class="card-header">
                        <h3 class="card-title">clearances</h3>
                    </div> --}}
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
                                @foreach ($deposits as $deposit)
                                <tr>
                                    <td>{{$deposit->calendar->id}}</td>
                                    <td>{{$deposit->calendar->calendar_year}}</td>
                                    <td>{{$deposit->calendar->month_name}}</td>
                                    <td>{{$deposit->manufacturer->short_name}}</td>
                                    <td>{{$deposit->vat_deposit}}</td>
                                    <td>{{$deposit->sd_deposit}}</td>
                                    <td>{{$deposit->hdsc_deposit}}</td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm editDeposit" href="javascript:void(0)"
                                            data-id="{{ $deposit->id }}">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                        </a>
                                        <a class="btn btn-danger btn-sm deleteDeposit" href="javascript:void(0)"
                                            data-id="{{ $deposit->id }}">
                                            <i class="fas fa-trash">
                                            </i>
                                        </a>
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
                <form id="DepositForm" name="DepositForm" class="form-horizontal">
                    @csrf
                    <input type="hidden" name="deposit_id" id="deposit_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                @php
                                $distinct_calendar = $calendar->unique('calendar_year');
                                @endphp

                                <label for="year">Year</label>
                                <select class="form-control" id="year" name="year">
                                    <option selected disabled>Select Year</option>
                                    @foreach ($distinct_calendar as $calendar_data)
                                    <option value="{{ $calendar_data->calendar_year }}">
                                        {{ $calendar_data->calendar_year }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select class="form-control" id="month" name="month">
                                    <option selected disabled>Select Period</option>
                                    @foreach ($calendar as $calendar_data)
                                    <option value="{{$calendar_data->calendar_period}}">
                                        {{$calendar_data->calendar_period}}</option>
                                    @endforeach
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
                                    @foreach ($manufacturers as $manufacturer)
                                    <option value="{{$manufacturer->id}}">{{$manufacturer->short_name}}</option>
                                    @endforeach
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
            "responsive": true, "autoWidth": false, 
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
                    url: "{{ route('deposit.import') }}",
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
@endsection