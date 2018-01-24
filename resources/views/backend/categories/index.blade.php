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
      <div id="message">
        @include('flash::message')
      </div>
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
                  <th class="text-center" width="15%">
                    {{ __('categories.options') }}
                  </th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="category-title-field">
                      <p>Title 1</p>
                      <input type="text" category-id="1" value="" spellcheck="false" hidden>
                    </td>
                    <td class="text-center">41</td>
                    <td class="text-center" width="15%">
                      <button type="button" class="btn btn-primary btn-flat fa fa-pencil btn-edit-category">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td class="category-title-field">
                      <p>Title 2</p>
                      <input type="text" category-id="2" value="" spellcheck="false" hidden>
                    </td>
                    <td class="text-center">11</td>
                    <td class="text-center" width="15%">
                      <button type="button" class="btn btn-primary btn-flat fa fa-pencil btn-edit-category">
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td class="category-title-field">
                      <p>Title 3</p>
                      <input type="text" category-id="3" value="" spellcheck="false" hidden>
                    </td>
                    <td class="text-center">15</td>
                    <td class="text-center" width="15%">
                      <button type="button" class="btn btn-primary btn-flat fa fa-pencil btn-edit-category">
                    </td>
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
