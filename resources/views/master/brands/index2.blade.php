@extends('layouts.master')

@section('content-title')
Brands Page
@endsection

@section('content-body')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Add New Brand</h3>
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
                                <label for="brand_name">Brand Name</label>
                                <input type="text" class="form-control" id="brand_name" name="brand_name"
                                    placeholder="Brand Name">

                            </div>
                            <div class="form-group">
                                <label for="short_name">Short Name</label>
                                <input type="text" class="form-control" id="short_name" name="short_name"
                                    placeholder="Short Name">
                            </div>
                            <div class="form-group">
                                <label for="segment_id">Segment</label>
                                <select class="form-control" id="segment_id" name="segment_id">
                                    <option selected disabled>Select Segment</option>
                                    @foreach ($segments as $segment)
                                    <option value="{{$segment->id}}">{{$segment->internal_segment}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="manufacturer_id">Manufacturer</label>
                                <select class="form-control" id="manufacturer_id" name="manufacturer_id">
                                    <option selected disabled>Select Manufacturer</option>
                                    @foreach ($manufacturers as $manufacturer)
                                    <option value="{{$manufacturer->id}}">{{$manufacturer->short_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
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
                                    <th>Brands</th>
                                    <th>Short Name</th>
                                    <th>Segment</th>
                                    <th>Manufacturer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=0;
                                @endphp
                                @foreach ($brands as $brand)
                                @php
                                $i++;
                                @endphp

                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$brand->brand_name}}</td>
                                    <td>{{$brand->short_name}}</td>
                                    <td>{{$brand->manufacturer_id}}</td>
                                    <td>{{$brand->segment_id}}</td>
                                    <td>{{$brand->status}}</td>
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
                url: "{{ route('brand.store') }}", 
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, 
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), 
                    brand_name: $("#brand_name").val(),
                    short_name: $("#short_name").val(),
                    manufacturer_id: $("#manufacturer_id").val(),
                    segment_id: $("#segment_id").val(),
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