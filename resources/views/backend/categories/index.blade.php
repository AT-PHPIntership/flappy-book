@extends('backend.layouts.master')
@section('title')
    {{ __('categories.list_categories') }}
@endsection
@section('content')
<script type="text/javascript">
  categories = {!! json_encode(trans('categories')) !!};
</script>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('categories.list_categories') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> {{ __('categories.home') }}</a></li>
        <li><a href="{{ route('categories.index') }}">{{ __('categories.categories') }}</a></li>
        <li class="active">{{ __('categories.list') }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('flash::message')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              @include('backend.categories.partials.add-category')
              <div class="pull-left">
                <button type="button" name="btn-add" id="btn-add-category" class="btn btn-success btn-flat">{{ __('categories.add_category') }}</button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @include('backend.layouts.partials.confirm-edit')
              @include('backend.layouts.partials.modal')
              <table id="list-categories" class="table table-bordered table-hover">
                <thead>
                 <tr>
                  <th class="text-center" width="5%">{{ __('categories.no') }}</th>
                  <th>{{ __('categories.title') }}</th>
                  <th class="text-center" width="10%">{{ __('categories.total_books') }}</th>
                  <th class="text-center" width="15%">
                    {{ __('categories.options') }}
                  </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $index => $category)
                  <tr class="item-{{ $category->id }}">
                    <td class="text-center">{{ $index + $categories->firstItem() }}</td>
                    <td class="category-title-field">
                      <p>{{ $category->title }}</p>
                      <input type="text" category-id="{{ $category->id }}" value="" spellcheck="false" hidden>
                      <span class="text-danger"></span>
                    </td>
                    <td class="text-center">{{ $category->total_books }}</td>
                    <td class="text-center">
                      @if ($category->id != App\Model\Category::CATEGORY_DEFAULT)
                        <div class="btn-option text-center">
                          <button type="button" class="btn btn-primary btn-flat fa fa-pencil btn-edit-category"></button>
                          <form method="POST" action="{{ route('categories.destroy', $category->id) }}" class="inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="button" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                              data-title="{{ __('categories.confirm_deletion') }}"
                              data-confirm="{{ __('categories.are_you_sure_to_delete_this_category', ['name' => $category->title]) }}">
                            </button>
                          </form> 
                        </div>
                      @endif
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              <!-- .pagination -->
              <div class="text-right">
                <nav aria-label="...">
                  {{ $categories->links() }}
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
