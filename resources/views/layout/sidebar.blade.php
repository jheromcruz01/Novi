<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <!-- <img src="{{ asset('res/logo.JPG') }}" alt="Fixed Asset" class="brand-image img-circle" width="200"> -->
     <h3>Novinovusclo</h3>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    @if (isset($resource))
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('res/blank.webp') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ $resource }}</a>
      </div>
    </div>
    @endif

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      @if(auth()->user()->is_admin == 1)
        <li class="nav-item">
          <a href="/home" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Home
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/customers" class="nav-link {{ request()->is('customers') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Customers
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/products" class="nav-link {{ request()->is('products') ? 'active' : '' }}">
            <i class="nav-icon fas fa-boxes"></i>
            <p>
              Inventory
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/transactions" class="nav-link {{ request()->is('transactions') ? 'active' : '' }}">
            <i class="nav-icon fa fa-money-bill"></i>
            <p>
              Transactions
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/expenses" class="nav-link {{ request()->is('expenses') ? 'active' : '' }}">
            <i class="nav-icon fas fa-dollar-sign"></i>
            <p>
              Expenses
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/users" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
            </p>
          </a>
        </li>
      @endif
        
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>