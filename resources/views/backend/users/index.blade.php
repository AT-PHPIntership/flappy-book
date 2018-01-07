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
                </tr>
                </thead>
                <tbody>
                <?php
                $number = 1;
                ?>
                @foreach ($users as $user)
                <?php
                    $id = $user['id'];
                    $employCode = $user['employ_code'];
                    $name = $user['name'];
                    $email = $user['email'];
                    $totalBorrowed = $user['total_borrowed'];
                    $totalDonated = $user['total_donated'];
                ?>
                <tr>
                  <td>{{ $number }}</td>
                  <td>{{ $employCode }}</td>
                  <td>{{ $name }}</td>
                  <td>{{ $email }}</td>
                  <td>{{ $totalDonated }}</td>
                  <td>{{ $totalBorrowed }}</td>
                </tr>
                <?php
                $number++;
                ?>
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
