@extends('backend.layouts.master')
@section('title')
    {{ __('languages.list_languages') }}
@endsection
@section('content')
<script type="text/javascript">
  languages = {!! json_encode(trans('languages')) !!};
</script>
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
      @include('flash::message')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header" id="btn-modified">
              @include('backend.languages.partials.add-language')
              <div class="pull-left">
                <button type="button" name="btn-add" id="btn-add-language" class="btn btn-success btn-flat">{{ __('languages.add_language') }}</button>
              </div>
            </div>
            <!-- /.box-header -->
            @include('backend.languages.partials.confirm-edit-language')
            <div class="box-body" id="table-modified">
              @include('backend.layouts.partials.modal')
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
                  @foreach ($languages as $index => $language)
                    <tr class="item-{{ $language->id }}">
                      <td class="text-center">{{ $index + $languages->firstItem() }}</td>
                      <td class="language-title-field">
                        <p>{{ $language->language }}</p>
                        <input type="text" language-id="{{ $language->id }}" value="" spellcheck="false" hidden>
                        <span class="text-danger"></span>
                      </td>
                      <td class="text-center">
                        <div class="btn-option text-center">
                          <button type="button" class="btn btn-primary btn-flat fa fa-pencil btn-edit-language"></button>
                          @if ($language->id != App\Model\Language::LANGUAGE_DEFAULT)
                            <form method="POST" action="{{ route('languages.destroy', $language->id) }}" class="inline">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <button type="button" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                              data-title="{{ __('languages.confirm_deletion') }}"
                              data-confirm="{{ __('languages.confirm_content', ['name' => $language->language]) }}">
                              </button>
                            </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <!-- .pagination -->
              <div class="text-right">
                <nav aria-label="...">
                  {{ $languages->links() }}
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
