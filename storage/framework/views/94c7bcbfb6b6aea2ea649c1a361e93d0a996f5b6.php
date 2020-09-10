<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-cyan elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo e(route('dashboard')); ?>" class="brand-link">
    <img src="dist/img/Logo.png" alt="Logo" class="brand-image img-circle elevation-8">
    <span class="brand-text font-weight-bold text-md text-grey">Clearance Data Analytics</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="dist/img/user.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="<?php echo e(route('dashboard')); ?>" class="d-block">
          <span class="font-weight-bold text-grey"><?php echo e(Auth::user()->name); ?></span>
        </a>
      </div>
    </div>

    <?php echo $__env->make('inc.sidebar_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <!-- /.sidebar -->
</aside><?php /**PATH C:\xampp\htdocs\clearance_data_analytics\resources\views/inc/sidebar.blade.php ENDPATH**/ ?>