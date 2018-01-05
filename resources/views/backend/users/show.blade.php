@extends('backend.layouts.master')
@section('title')
    {{ __('users.detail_user') }}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('users.detail_user') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('users.home') }}</a></li>
        <li><a href="#">{{ __('users.users') }}</a></li>
        <li class="active">{{ __('users.user_profile') }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" alt="User profile picture">

              <h3 class="profile-username text-center">Tram Pham T.M.</h3>

              <p class="text-muted text-center">PHP Team</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>{{ __('users.employee_code') }}</b> <a class="pull-right">ATI-0282</a>
                </li>
                <li class="list-group-item">
                  <b>{{ __('users.email') }}</b> <a class="pull-right">tram.pham@asiantech.com</a>
                </li>
                <li class="list-group-item">
                  <b>{{ __('users.role') }}</b> <a class="pull-right">User</a>
                </li>
                <li class="list-group-item">
                  <b>{{ __('users.books_donated') }}</b> <a class="pull-right" href="">2</a>
                </li>
                <li class="list-group-item">
                  <b>{{ __('users.books_borrowed') }}</b> <a class="pull-right" href="">3</a>
                </li>
                <li class="list-group-item">
                  <b>{{ __('users.books_borrowing') }}</b> <a class="pull-right">1</a>
                </li>
              </ul>
              <a href="javascript:history.back()" class="btn btn-primary btn-block"><b>{{ __('users.back')}}</b></a>
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
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->
@endsection