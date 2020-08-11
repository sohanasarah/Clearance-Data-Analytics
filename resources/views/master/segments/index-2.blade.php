@extends('layouts.master')

@section('content-title')
Segments Page
@endsection

@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Add Segments</h3>
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
                            <div class="form-group">
                                <label for="fullname">Internal Segment</label>
                                <input type="text" class="form-control" id="internal_segment">
                                

                            <div class="form-group">
                                <label for="shortname">External Segment 1</label>
                                <input type="text" class="form-control" id="external_segment1">
                                @if($errors->has('external_segment1'))
                                <div class="error">{{ $errors->first('external_segment1') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="shortname">External Segment 2</label>
                                <input type="text" class="form-control" id="external_segment2">
                                @if($errors->has('external_segment2'))
                                <div class="error">{{ $errors->first('external_segment2') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status">
                                    <option selected disabled>Select status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Segment Database</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Internal Segment</th>
                                    <th>External Segment1</th>
                                    <th>External Segment2</th>
                                    <th>Status</th>
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
                                    <td>{{$list_item->internal_segment}}</td>
                                    <td>{{$list_item->external_segment1}}</td>
                                    <td>{{$list_item->external_segment2}}</td>
                                    <td>{{$list_item->status}}</td>
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
            "responsive": true
            , "autoWidth": false
        , });

        //Submit Data
        $("#submit").click(function(e) {
            e.preventDefault();
            $(".print-error-msg").hide();
            $(".print-success-msg").hide();

            $.ajax({
                url: "{{ route('segment.store') }}", 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    internal_segment: $("#internal_segment").val(),
                    external_segment1: $("#external_segment1").val(),
                    external_segment2: $("#external_segment2").val(),
                    status: $("#status").val(),
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