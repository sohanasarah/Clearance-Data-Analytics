@extends('layouts.master')

@section('content-title')
Clearance
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
                                            <option selected disabled>Select month</option>
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
                                        <label for="item_id">Item</label>
                                        <select class="form-control" id="item_id" name="item_id">
                                            <option selected disabled>Select Item</option>
                                            @foreach ($items as $item)
                                            <option value="{{$item->id}}">{{$item->item_name}}
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
                                        <input type="text" class="form-control" id="figure" name="figure"
                                            placeholder="Figure">
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
                        <h3 class="card-title">Clearance Data</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Measure</th>
                                    <th>Item</th>
                                    <th>Figure</th>
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
                                    <td>{{$clearance_data->calendar_id}}</td>
                                    <td>{{$clearance_data->calendar_id}}</td>
                                    <td>{{$clearance_data->measure}}</td>
                                    <td>{{$clearance_data->item_id}}</td>
                                    <td>{{$clearance_data->figure}}</td>
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
                url: "{{ route('clearance.store') }}", 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    year: $("#year").val(),
                    month: $("#month").val(),
                    item_id: $("#item_id").val(),
                    measure: $("#measure").val(),
                    figure: $("#figure").val(),
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