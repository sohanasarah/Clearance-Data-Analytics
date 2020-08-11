@extends('layouts.master')

@section('content-title')
Calendar
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
                                        <input type="text" class="form-control" id="year" name="year"
                                            placeholder="2020">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="period">Period</label>
                                        <input type="text" class="form-control" id="period" name="period"
                                            placeholder="07">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="period">Month Name</label>
                                    <input type="text" class="form-control" id="month_name" name="month_name"
                                        placeholder="Jul">
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
                                        <label for="status">Expired</label>
                                        <select class="form-control" id="expired" name="expired">
                                            <option selected disabled>Select</option>
                                            <option value="true">True</option>
                                            <option value="false">False</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option selected disabled>Select status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
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
            </div>
            <!--/.col -->
            <div class="col-8">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Calendar</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Calendar Year</th>
                                    <th>Calendar Period</th>
                                    <th>Month Name</th>
                                    <th>Fiscal Year</th>
                                    <th>Fiscal Period</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=0;
                                @endphp
                                @foreach ($calendar as $calendar_data)
                                @php
                                $i++;
                                @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$calendar_data->calendar_year}}</td>
                                    <td>{{$calendar_data->calendar_period}}</td>
                                    <td>{{$calendar_data->month_name}}</td>
                                    <td>{{$calendar_data->fiscal_year}}</td>
                                    <td>{{$calendar_data->fiscal_period}}</td>
                                    <td>{{$calendar_data->status}}</td>
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
                url: "{{ route('calendar.store') }}", 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    year: $("#year").val(),
                    period: $("#period").val(),
                    fiscal_year: $("#fiscal_year").val(),
                    fiscal_period: $("#fiscal_period").val(),
                    month_name: $("#month_name").val(),
                    expired: $("#expired").val(),
                    status: $("#status").val(),
                },
                success: function(response) {
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