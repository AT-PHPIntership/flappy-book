@extends('backend.layouts.master')
@section('title')
    {{ __('languages.list_languages') }}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('languages.list_languages') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.home.index') }}"><i class="fa fa-dashboard"></i> {{ __('languages.home') }}</a></li>
        <li><a href="{{ route('languages.index') }}">{{ __('languages.languages') }}</a></li>
        <li class="active">{{ __('languages.list') }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header" id="btn-modified">
              <div class="pull-left">
                <button type="button" name="btn-add" id="btn-add-languages" class="btn btn-success btn-flat">{{ __('languages.add_language') }}</button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="table-modified">
              <table id="list-languages" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th class="text-center" width="5%">{{ __('languages.no') }}</th>
                  <th>{{ __('languages.name') }}</th>
                  <th class="text-center" width="20%">
                    {{ __('languages.options') }}
                  </th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">1</td>
                    <td class="language-title-field">
                      <p>English</p>
                      <input type="text" language-id="" value="" spellcheck="false" hidden>
                      <span class="text-danger"></span>
                    </td>
                    <td class="text-center">
                      <div class="btn-option text-center">
                        <button type="button" class="btn btn-primary btn-flat fa fa-pencil btn-edit-language"></button>
                        <form method="" action="" class="inline">
                          <button type="button" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item">
                          </button>
                        </form> 
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">2</td>
                    <td class="language-title-field">
                      <p>Japanese</p>
                      <input type="text" language-id="" value="" spellcheck="false" hidden>
                      <span class="text-danger"></span>
                    </td>
                    <td class="text-center">
                      <div class="btn-option text-center">
                        <button type="button" class="btn btn-primary btn-flat fa fa-pencil btn-edit-language"></button>
                        <form method="" action="" class="inline">
                          <button type="button" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item">
                          </button>
                        </form> 
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="text-center">3</td>
                    <td class="language-title-field">
                      <p>Vietnamese</p>
                      <input type="text" language-id="" value="" spellcheck="false" hidden>
                      <span class="text-danger"></span>
                    </td>
                    <td class="text-center">
                      <div class="btn-option text-center">
                        <button type="button" class="btn btn-primary btn-flat fa fa-pencil btn-edit-language"></button>
                        <form method="" action="" class="inline">
                          <button type="button" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item">
                          </button>
                        </form> 
                      </div>
                    </td>
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
