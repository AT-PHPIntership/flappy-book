@extends('backend.layouts.master')
@section('title')
    {{ __('users.list_users') }}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('users.list_users') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('users.home') }}</a></li>
        <li><a href="#">{{ __('users.users') }}</a></li>
        <li class="active">{{ __('users.list') }}</li>
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
                  <th>{{ __('users.no') }}</th>
                  <th>{{ __('users.employee_code') }}</th>
                  <th>{{ __('users.name') }}</th>
                  <th>{{ __('users.email') }}</th>
                  <th>{{ __('users.donate') }}</th>
                  <th>{{ __('users.borrowed') }}</th>
                  <th class="text-center">{{ __('users.role') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $index => $user)
                <tr>
                  <td>{{ $index + $users->firstItem() }}</td>
                  <td>{{ $user->employ_code }}</td>
                  <td><a href="{{ route('users.show', ['id' =>$user->id]) }}">{{ $user->name }}</a></td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->books_count }}</td>
                  <td>{{ $user->borrows_count }}</td>
                  <td class="text-center"><button type="button" name="btn-role" id="btn-role" class="btn btn-danger btn-flat btn-xs" style="width: 45px">{{ __('users.admin') }}</button>
                </tr>
                @endforeach
                </tbody>
              </table>
              <!-- .pagination -->
              <div class="text-right">
                <nav aria-label="...">
                    <ul class="pagination">
                        {{ $users->links() }}
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
