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
        <li class="active">{{ __('borrows.list') }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="pull-right col-xs-6">
                <form action="{{ route('borrows.index') }}" method="GET">
                    <div class="col-xs-6">
                      <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('borrows.search') }}">
                    </div>
                    <div class="col-xs-4">
                      <select name="filter" id="filter" class="form-control">
                        @foreach( __('borrows.list_search') as $key => $search )
                          <option value="{{ $key }}" {{$key == app('request')->input('filter') ? 'selected' : '' }}>{{ $search }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-xs-2">
                      <button type="submit" id="btn-search" class="btn btn-primary btn-flat">{{ __('borrows.search') }}</button>
                    </div>
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="list-borrows" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th class="text-center">@sortablelink('employ_code', __('borrows.employee_code'))</th>
                  <th>@sortablelink('name', __('borrows.name'))</th>
                  <th>@sortablelink('email', __('borrows.email'))</th>
                  <th>@sortablelink('title', __('borrows.book_borrowing'))</th>
                  <th class="text-center">@sortablelink('from_date', __('borrows.from_date'))</th>
                  <th class="text-center">@sortablelink('to_date', __('borrows.end_date'))</th>
                  <th class="text-center">@sortablelink('send_mail_date',  __('borrows.send_mail_date'))</th>
                  <th class="text-center">{{ __('borrows.reminder') }}</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($borrows as $borrow)
                    <tr>
                      <td class="text-center">{{ $borrow->employ_code }}</td>
                      <td>{{ $borrow->name }}</td>
                      <td>{{ $borrow->email }}</td>
                      <td>{{ $borrow->title }}</td>
                      <td class="text-center">{{ date('d-m-Y', strtotime($borrow->from_date)) }}</td>
                      <td class="text-center">{{ date('d-m-Y', strtotime($borrow->to_date)) }}</td>
                      <td>{{ date('d-m-Y', strtotime($borrow->send_mail_date)) }}</td>
                      <td class="text-center">
                        <form>
                          <button type="button" class="btn btn-warning btn-flat btn-xs btn-send fa fa-bell-o"></button>
                        </form>
                      </td>
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
