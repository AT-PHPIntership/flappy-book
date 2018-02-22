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
            @if(count($qrcodes) > 0)
              <div class="box-header" id="btn-download">
                <div class="pull-left">
                  <a href="{{ route('qrcodes.index', 'export') }}"><button type="button" name="btn-add" id="btn-download-qrcodes" class="btn btn-success btn-flat">{{ __('qrcodes.download') }}</button></a>
                </div>
              </div>
            <!-- /.box-header -->
            <div class="box-body" id="table-qrcodes">
              <table id="list-qrcodes" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th class="text-center" width="15%">{{ __('qrcodes.no') }}</th>
                  <th>{{ __('qrcodes.book_title') }}</th>
                  <th class="text-center">{{ __('qrcodes.qrcode') }}</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($qrcodes as $index => $qrcode)
                    <tr>
                      <td class="text-center">{{ $index + $qrcodes->firstItem() }}</td>
                      <td>{{ $qrcode->title }}</td>
                      <td class="text-center">{{ $qrcode->qrcode_book }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- .pagination -->
              <div class="text-right">
                <nav aria-label="...">
                  {{ $qrcodes->links() }}
                </nav>
              </div>
              <!-- /.box-body -->
            @endif
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
