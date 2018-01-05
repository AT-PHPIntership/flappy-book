@extends('backend.layouts.master')
@section('title')
    {{ __('Dashboard') }}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('Detail User') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
        <li><a href="#">{{ __('Users') }}</a></li>
        <li class="active">{{ __('User profile') }}</li>
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
                  <b>Employee Code</b> <a class="pull-right">ATI-0282</a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right">tram.pham@asiantech.com</a>
                </li>
                <li class="list-group-item">
                  <b>Role</b> <a class="pull-right">User</a>
                </li>
                <li class="list-group-item">
                  <b>Books Donated</b> <a class="pull-right" href="">2</a>
                </li>
                <li class="list-group-item">
                  <b>Books Borrowed</b> <a class="pull-right" href="">3</a>
                </li>
                <li class="list-group-item">
                  <b>Books Borrowing</b> <a class="pull-right">HTML5</a>
                </li>
              </ul>
              <a href="javascript:history.back()" class="btn btn-primary btn-block"><b>Back</b></a>
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
