@extends('backend.layouts.master')
@section('title')
    {{ __('borrows.list_borrows') }}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('borrows.list_borrows') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.home.index') }}"><i class="fa fa-dashboard"></i> {{ __('borrows.home') }}</a></li>
        <li><a href="{{ route('borrows.index') }}">{{ __('borrows.borrows') }}</a></li>
        <li class="active">{{ __('borrows.list_borrower') }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th class="text-center">@sortablelink('employ_code', __('borrows.employee_code'))</th>
                  <th>@sortablelink('name', __('borrows.name'))</th>
                  <th>@sortablelink('email', __('borrows.email'))</th>
                  <th>@sortablelink('title', __('borrows.book_borrowing'))</th>
                  <th class="text-center">@sortablelink('from_date', __('borrows.from_date'))</th>
                  <th class="text-center">@sortablelink('to_date', __('borrows.end_date'))</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($borrows as $index => $borrow)
                    <tr>
                      <td class="text-center">{{ $borrow->employ_code }}</td>
                      <td>{{ $borrow->name }}</td>
                      <td>{{ $borrow->email }}</td>
                      <td>{{ $borrow->title }}</td>
                      <td class="text-center">{{ date('d-m-Y', strtotime($borrow->from_date)) }}</td>
                      <td class="text-center">{{ date('d-m-Y', strtotime($borrow->to_date)) }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- .pagination -->
              <div class="text-right">
                <nav aria-label="...">
                    <ul class="pagination">
                      {{ $borrows->links() }}
                    </ul>
                </nav>
              </div>
              <!-- /.pagination -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
