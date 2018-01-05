@extends('backend.layouts.master') 
@section('title') 
{{ __('List Books') }} 
@endsection 
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ __('List Books') }}
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="#">
          <i class="fa fa-dashboard"></i> {{ __('Home') }}</a>
      </li>
      <li>
        <a href="#">{{ __('Books') }}</a>
      </li>
      <li class="active">{{ __('List') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">

          </div>
          <!-- /.box-header -->
          <div class="box-body">
            @include('backend.layouts.partials.modal')
            <table id="example2" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="5%">
                    {{ __('No') }}
                  </th>
                  <th>
                    {{ __('Name') }}
                    <a href="{{ route('books.index', ['filter' => 'title', 'order' => 'asc']) }}" class="pull-right">
                      <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                    </a>
                  </th>
                  <th>
                   {{ __('Author') }}
                    <a href="{{ route('books.index', ['filter' => 'author', 'order' => 'asc']) }}" class="pull-right">
                      <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                    </a>
                  </th>
                  <th class="text-center">
                    {{ __('Rate') }}
                    <a href="{{ route('books.index', ['filter' => 'rating', 'order' => 'asc']) }}" class="pull-right">
                      <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                    </a>
                  </th>
                  <th class="text-center" width="12%">
                    {{ __('Total borrow') }}
                    <a href="{{ route('books.index', ['filter' => 'total_borrow', 'order' => 'asc']) }}" class="pull-right">
                      <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                    </a>
                  </th>
                  <th class="text-center" width="15%">
                    {{ __('Options') }}
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Trident</td>
                  <td>Internet Explorer 4.0
                  </td>
                  <td>Win 95+</td>
                  <td class="text-center">4</td>
                  <td class="text-center">X</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Trident</td>
                  <td>Internet Explorer 5.0
                  </td>
                  <td>Win 95+</td>
                  <td class="text-center">5</td>
                  <td class="text-center">C</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Trident</td>
                  <td>Internet Explorer 5.5
                  </td>
                  <td>Win 95+</td>
                  <td class="text-center">5.5</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Trident</td>
                  <td>Internet Explorer 6
                  </td>
                  <td>Win 98+</td>
                  <td class="text-center">6</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Trident</td>
                  <td>Internet Explorer 7</td>
                  <td>Win XP SP2+</td>
                  <td class="text-center">7</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Trident</td>
                  <td>AOL browser (AOL desktop)</td>
                  <td>Win XP</td>
                  <td class="text-center">6</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Gecko</td>
                  <td>Firefox 1.0</td>
                  <td>Win 98+ / OSX.2+</td>
                  <td class="text-center">1.7</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Gecko</td>
                  <td>Firefox 1.5</td>
                  <td>Win 98+ / OSX.2+</td>
                  <td class="text-center">1.8</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Gecko</td>
                  <td>Firefox 2.0</td>
                  <td>Win 98+ / OSX.2+</td>
                  <td class="text-center">1.8</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Gecko</td>
                  <td>Firefox 3.0</td>
                  <td>Win 2k+ / OSX.3+</td>
                  <td class="text-center">1.9</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Gecko</td>
                  <td>Camino 1.0</td>
                  <td>OSX.2+</td>
                  <td class="text-center">1.8</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
                  <td >Gecko</td>
                  <td>Camino 1.5</td>
                  <td>OSX.3+</td>
                  <td class="text-center">1.8</td>
                  <td class="text-center">A</td>
                  <td class="text-center">
                    <div class="btn-option text-center">
                      <a href="#" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                      <form method="POST" action="#" class="inline">
                        <button type="submit" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                          data-title="{{ __('Confirm deletion!') }}"
                          data-confirm="{{ __('Are you sure you want to delete?') }}"
                        ></button>
                      </form> 
                    </div>
                  </td>
                </tr>
                <tr>
              </tbody>
            </table>
            <div class="text-right">
              <nav aria-label="...">
                <ul class="pagination">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="#">2
                      <span class="sr-only">(current)</span>
                    </a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">3</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
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
