@extends('backend.layouts.master')
@section('title')
    {{ __('qrcodes.list_qrcodes') }}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('qrcodes.list_qrcodes') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('qrcodes.home') }}</a></li>
        <li><a href="{{ route('qrcodes.index') }}">{{ __('qrcodes.qrcodes') }}</a></li>
        <li class="active">{{ __('qrcodes.list') }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <div class="pull-left">
                <button type="button" name="btn-add" id="btn-add-category" class="btn btn-success btn-flat">{{ __('qrcodes.download') }}</button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="list-qrcodes" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th class="text-center" width="8%">{{ __('qrcodes.no') }}</th>
                  <th class="text-center">{{ __('qrcodes.qrcode') }}</th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="text-center">ATB-0345</td>
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td class="text-center">ATB-2846</td>
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td class="text-center">ATB-8947</td>
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
