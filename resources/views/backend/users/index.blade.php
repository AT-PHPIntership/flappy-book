@extends('backend.layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Users</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>No</th>
                  <th>Employee Code</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Donate</th>
                  <th>Borrowed</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td>AT-1802</td>
                  <td>Tram Pham T.M.</td>
                  <td>tram.pham@asiantech.com</td>
                  <td>2</td>
                  <td>CSS</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>AT-1802</td>
                  <td>Duong N.T</td>
                  <td>duong.tran@asiantech.com</td>
                  <td>2</td>
                  <td>HTML5</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>AT-1802</td>
                  <td>Hieu L.T.</td>
                  <td>hieu.le@asiantech.com</td>
                  <td>2</td>
                  <td>HTML3</td>
                </tr>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
