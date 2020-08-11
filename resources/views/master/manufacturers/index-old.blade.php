@extends('layouts.master')

@section('content-title')
Manufacturer Page
@endsection

@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Add Manufacturer</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" method="POST">

                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="alert alert-success print-success-msg" style="display:none">
                        </div>

                        <div class="card-body">
                            <div class="form-group">
                                <label for="fullname">Manufacturer Name</label>
                                <input type="text" class="form-control" id="full_name" placeholder="Full Name">
                                @if($errors->has('full_name'))
                                <div class="error">{{ $errors->first('full_name') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="shortname">Short Name</label>
                                <input type="text" class="form-control" id="short_name" placeholder="Short Name">
                                @if($errors->has('short_name'))
                                <div class="error">{{ $errors->first('short_name') }}</div>
                                @endif
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
            <div class="col-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">All Manufacturers</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Manufacturer Name</th>
                                    <th>Short Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=0;
                                @endphp
                                @foreach ($list as $list_item)
                                @php
                                $i++;

                                @endphp
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$list_item->full_name}}</td>
                                    <td>{{$list_item->short_name}}</td>
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

            var short_name = $("#short_name").val();
            var full_name = $("#full_name").val();
            var url = '{{ route('manufacturer.store') }}';

            $.ajax({
                url: url, 
                type: 'POST', 
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    short_name: short_name, 
                    full_name: full_name
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