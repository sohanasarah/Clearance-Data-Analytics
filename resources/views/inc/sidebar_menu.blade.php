<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar nav-compact flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->

    <li class="nav-item">
      <a href="{{ route('dashboard') }}" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-copy"></i>
        <p>
          Master Data
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('manufacturer.index') }}" class="nav-link">
            <i class="fas fa-industry nav-icon"></i>
            <p class="text-sm">
               Manufacturers
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('segment.index') }}" class="nav-link">
            <i class="fas fa-object-group nav-icon"></i>
            <p class="text-sm">
              Segments
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('brand.index') }}" class="nav-link">
            <i class="fas fa-tags nav-icon"></i>
            <p class="text-sm">
              Brands
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('calendar.index') }}" class="nav-link">
            <i class="far fa-calendar-alt nav-icon"></i>
            <p class="text-sm">
              Calendar
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('item.index') }}" class="nav-link">
            <i class="fas fa-box-open nav-icon"></i>
            <p class="text-sm">
              Items
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('deposit.index') }}" class="nav-link">
            <i class="fas fa-hand-holding-usd nav-icon"></i>
            <p class="text-sm">
              Deposits
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('clearance.index') }}" class="nav-link">
            <i class="fa fa-clipboard-check nav-icon"></i>
            <p class="text-sm">
              Clearance
            </p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
          Charts
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>

      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('charts.segments') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Segment Contribution</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Inactive Page</p>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
          Tables
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>

      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="far fa-circle nav-icon"></i>
            <p>Active Page</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Inactive Page</p>
          </a>
        </li>
      </ul>
    </li>


    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>
          Profile
        </p>
      </a>
    </li>

  </ul>
</nav>
<!-- /.sidebar-menu -->
</div>