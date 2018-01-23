<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ Auth::user()->avatar_url }}" class="img-circle circle-border text-center" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>
        <a href="{{ route('users.show', Auth::user()->id) }}"><i class="fa fa-circle text-success"></i> {{ __('dashboard.online') }}</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">{{ __('dashboard.main_navigation') }}</li>
      <li class="{{ checkActiveRoutes(['admin.home.index']) }}">
        <a href="{{ route('admin.home.index') }}"><i class="fa fa-dashboard"></i> <span>{{ __('dashboard.dashboard') }}</span></a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-table"></i> <span>Select Menu</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Item 1</a></li>
          <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Item 2</a></li>
        </ul>
      </li>
      <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Simple Menu</span></a></li>
      <li class="{{ checkActiveRoutes(['books.index','books.create', 'books.edit']) }}">
        <a href="{{ route('books.index') }}"><i class="fa fa-book"></i> <span>{{ __('dashboard.books') }}</span></a>
      </li>
      <li class="{{ checkActiveRoutes(['users.index','users.show', 'users.edit']) }}">
        <a href="{{ route('users.index') }}"><i class="fa fa-user-circle"></i> <span>{{ __('dashboard.users') }}</span></a>
      </li>
      <li class="{{ checkActiveRoutes(['borrows.index','borrows.show', 'borrows.edit']) }}">
        <a href="{{ route('borrows.index') }}"><i class="glyphicon glyphicon-list-alt"></i> <span>{{ __('dashboard.borrows') }}</span></a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
