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
                  <th width="40%">
                    {{ __('Name') }}
                    <a href="{{ route('books.index', ['filter' => 'title', 'order' => $order]) }}" class="pull-right">
                      <i class="fa fa-sort-amount-{{$order}}" aria-hidden="true"></i>
                    </a>
                  </th>
                  <th width="25%">
                   {{ __('Author') }}
                    <a href="{{ route('books.index', ['filter' => 'author', 'order' => $order]) }}" class="pull-right">
                      <i class="fa fa-sort-amount-{{$order}}" aria-hidden="true"></i>
                    </a>
                  </th>
                  <th width="10%">
                    {{ __('Rate') }}
                    <a href="{{ route('books.index', ['filter' => 'rating', 'order' => $order]) }}" class="pull-right">
                      <i class="fa fa-sort-amount-{{$order}}" aria-hidden="true"></i>
                    </a>
                  </th>
                  <th width="10%">
                    {{ __('Total borrow') }}
                    <a href="{{ route('books.index', ['filter' => 'total_borrow', 'order' => $order]) }}" class="pull-right">
                      <i class="fa fa-sort-amount-{{$order}}" aria-hidden="true"></i>
                    </a>
                  </th>
                  <th class="text-center" width="10%">
                    {{ __('Options') }}
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($books as $book)
                <tr>
                  <td>{{ $book->id }}</td>
                  <td>{{ $book->title }}</td>
                  <td>{{ $book->author }}</td>
                  <td>{{ $book->rating }}</td>
                  <td>{{ $book->total_borrow }}</td>
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
                @endforeach
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
