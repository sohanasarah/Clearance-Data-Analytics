<!DOCTYPE html>
<html lang="en">

<head>
  @include('inc.header')
  <!-- STYLES -->
  @include('inc.styles')
  <!-- REQUIRED SCRIPTS -->
  @include('inc.scripts')
</head>

<body class="hold-transition sidebar-mini layout-fixed" style="height:auto">

  <!-- wrapper -->
  <div class="wrapper">
    @include('inc.navbar')
    @include('inc.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">

            <div class="col-sm-6">
              <h1 class="m-0">
                @yield('content-title')
              </h1>
            </div><!-- /.col -->

            <div class="col-sm-6">
              @include('inc.breadcrumb')
            </div><!-- /.col -->

          </div><!-- /.row -->


        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      @yield('content-body')

    </div>
    <!-- /.content-wrapper -->

    <script>
      $.ajaxSetup({
          headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
      });
    
        toastr.options = {
            "closeButton": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "onclick": true,
            "showDuration": "1000",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

    </script>
    

    @yield('page-script')
    @include('inc.dynamic-sidebar')
    @include('inc.footer')
  </div>
  <!-- ./wrapper -->

</body>

</html>