@extends('backend.layouts.master')
@section('title')
    {{ __('borrows.list_borrows') }}
@endsection
@section('content')
<script type="text/javascript">
  $role = {!! json_encode(trans('users')) !!};
</script>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('borrows.list_borrows') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('borrows.home') }}</a></li>
        <li><a href="#">{{ __('borrows.borrows') }}</a></li>
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
                  <th class="text-center">{{ __('borrows.employee_code') }}</th>
                  <th>{{ __('borrows.name') }}</th>
                  <th>{{ __('borrows.email') }}</th>
                  <th>{{ __('borrows.books_borrowing') }}</th>
                  <th class="text-center">{{ __('borrows.from_date') }}</th>
                  <th class="text-center">{{ __('borrows.end_date') }}</th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">ATI2018</td>
                    <td>Tram Pham T.M</td>
                    <td>tram.pham@asiantech.vn</td>
                    <td>CSS3</td>
                    <td class="text-center">22-01-2018</td>
                    <td class="text-center">28-01-2018</td>
                  </tr>
                  <tr>
                    <td class="text-center">ATI2019</td>
                    <td>Nhan Nguyen T.</td>
                    <td>nhan.nguyen@asiantech.vn</td>
                    <td>HTML5</td>
                    <td class="text-center">21-01-2018</td>
                    <td class="text-center">27-01-2018</td>
                </tbody>
              </table>
              <!-- .pagination -->
              <div class="text-right">
                <nav aria-label="...">
                    <ul class="pagination">
                      <li><a href="#">&laquo;</a></li>
                      <li><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">&raquo;</a></li>
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
