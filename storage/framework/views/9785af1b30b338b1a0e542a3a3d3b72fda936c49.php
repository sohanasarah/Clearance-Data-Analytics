<!DOCTYPE html>
<html lang="en">

<head>
  <?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- STYLES -->
  <?php echo $__env->make('inc.styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- REQUIRED SCRIPTS -->
  <?php echo $__env->make('inc.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed" style="height:auto">

  <!-- wrapper -->
  <div class="wrapper">
    <?php echo $__env->make('inc.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">

            <div class="col-sm-6">
              <h1 class="m-0">
                <?php echo $__env->yieldContent('content-title'); ?>
              </h1>
            </div><!-- /.col -->

            <div class="col-sm-6">
              <?php echo $__env->make('inc.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div><!-- /.col -->

          </div><!-- /.row -->


        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <?php echo $__env->yieldContent('content-body'); ?>

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
    

    <?php echo $__env->yieldContent('page-script'); ?>
    <?php echo $__env->make('inc.dynamic-sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  </div>
  <!-- ./wrapper -->

</body>

</html><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/layouts/master.blade.php ENDPATH**/ ?>