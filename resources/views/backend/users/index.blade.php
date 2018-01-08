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
                  <td>AT-1803</td>
                  <td>Duong N.T</td>
                  <td>duong.tran@asiantech.com</td>
                  <td>2</td>
                  <td>HTML5</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>AT-1804</td>
                  <td>Hieu L.T.</td>
                  <td>hieu.le@asiantech.com</td>
                  <td>2</td>
                  <td>CSS3</td>
                </tr>
                </tbody>
              </table>
              <!-- .pagination -->
              <div class="text-right">
                <nav aria-label="...">
                  <ul class="pagination">
                    <li class="page-item disabled">
                      <span class="page-link">Previous</span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                      <span class="page-link">
                        2
                        <span class="sr-only">(current)</span>
                      </span>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#">Next</a>
                    </li>
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
