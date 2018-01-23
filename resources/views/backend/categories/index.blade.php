@extends('backend.layouts.master')
@section('title')
    {{ __('categories.list_categories') }}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('categories.list_categories') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('categories.home') }}</a></li>
        <li><a href="#">{{ __('categories.categories') }}</a></li>
        <li class="active">{{ __('categories.list') }}</li>
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
                  <th class="text-center" width="5%">{{ __('categories.no') }}</th>
                  <th>{{ __('categories.title') }}</th>
                  <th class="text-center" width="10%">{{ __('categories.total_book') }}</th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td>Ea laboriosam eum in numquam tempor labore distinctio Eos quibusdam</td>
                    <td class="text-center">41</td>
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td>Kali Schuppe DDS</td>
                    <td class="text-center">25</td>
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td>Kali Schuppe DDS</td>
                    <td class="text-center">34</td>
                  </tr>
                  <tr>
                    <td class="text-center">4</td>
                    <td>Kali Schuppe DDS</td>
                    <td class="text-center">62</td>
                  </tr>
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
