@extends('layouts.master')

@section('content-title')
Deposits
@endsection

@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Add New Record</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" id="requestForm">
                        @csrf
                        <!-- {{ csrf_field() }} -->
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="alert alert-success print-success-msg" style="display:none">
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <select class="form-control" id="year" name="year">
                                            <option selected disabled>Select Year</option>
                                            @foreach ($calendar as $calendar_data)
                                            <option value="{{$calendar_data->calendar_year}}">
                                                {{$calendar_data->calendar_year}}</option>
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
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info" id="submit">Add</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">CSV Upload</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="">Upload</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col -->
            <div class="col-8">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">All Brands</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Year</th>
                                    <th>Manufacturer</th>
                                    <th>Vat Deposit</th>
                                    <th>SD Deposit</th>
                                    <th>HDSC Deposit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=0;
                                @endphp
                                @foreach ($deposits as $deposit)
                                @php
                                $i++;
                                @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$deposit->calendar_id}}</td>
                                    <td>{{$deposit->manufacturer_id}}</td>
                                    <td>{{$deposit->vat_deposit}}</td>
                                    <td>{{$deposit->sd_deposit}}</td>
                                    <td>{{$deposit->hdsc_deposit}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--/.col -->
        </div>
        <!--/.row -->
    </div>
    <!--/.container -->
</div>
<!-- /.content -->
@endsection

@section('page-script')
<script>
    $(function() {
        $("#myTable").DataTable({
            "responsive": true, "autoWidth": false, 
        });

        //Submit Data
        $("#submit").click(function(e) {
            e.preventDefault();
            $(".print-error-msg").hide();
            $(".print-success-msg").hide();

            $.ajax({
                url: "{{ route('deposit.store') }}", 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    year: $("#year").val(),
                    month: $("#month").val(), 
                    vat_deposit: $("#vat_deposit").val(),
                    sd_deposit: $("#sd_deposit").val(),
                    hdsc_deposit: $("#hdsc_deposit").val(),
                    manufacturer_id: $("#manufacturer_id").val(),
                },
                success: function(response) {
                    console.log(response);
                    toastr.success(response.message);
                    setTimeout(function () { 
                        document.location.reload(true); 
                    }, 3000);
                    
                },
                error: function(response){
                    console.log(response.responseJSON.errors);
                    $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display','block');
                        $.each( response.responseJSON.errors, function( key, value ) {
                            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                            toastr.error(value);
                    });
                }
            });
        });
    });

</script>
@endsection