@extends('backend.layouts.master')
@section('title')
    {{ __('posts.list_posts') }}
@endsection
@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ __('posts.list_posts') }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('admin.home.index') }}"><i class="fa fa-dashboard"></i> {{ __('posts.home') }}</a></li>
        <li><a href="{{ route('borrows.index') }}">{{ __('posts.posts') }}</a></li>
        <li class="active">{{ __('posts.list_posts') }}</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      @include('flash::message')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="list-posts" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th class="text-center" width="5%">
                      {{ __('posts.no') }}
                    </th>
                    <th class="text-left" width="30%">
                      {{ __('posts.short_content') }}
                    </th>
                    <th class="text-left" width="10%">
                      {{ __('posts.status') }}
                    </th>
                    <th class="text-left" width="18%">
                      {{ __('posts.user_name') }}
                    </th>
                    <th class="text-center" width="12%">
                      {{ __('posts.post_date') }}
                    </th>
                    <th class="text-center" width="10%">
                      {{ __('posts.total_comment') }}
                    </th>
                    <th class="text-center" width="15%">
                      {{ __('posts.options') }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $index => $post)
                    <tr>
                      <td class="text-center">{{ $index + $posts->firstItem() }}</td>
                      <td><a href="{{ route('posts.show', [$post->id, 'page' => request('page') ?? 1]) }}">{!! Str::words($post->content, config('define.posts.size_short_content'),config('define.posts.three_dots')) !!}</a></td>
                      <td class="text-left">
                        @switch($post->status)
                          @case(config('define.posts.type_review_book'))
                            {{ __('posts.review') }}
                            @break
                          @case(config('define.posts.type_status'))
                            {{ __('posts.status') }}
                            @break
                          @case(config('define.posts.type_find_book'))
                            {{ __('posts.find_book') }}
                            @break
                        @endswitch
                      </td>
                      <td class="text-left">{{ $post->name }}</td>
                      <td class="text-center">{{ date(config('define.posts.date_format'), strtotime($post->created_at)) }}</td>
                      <td class="text-center">{{ $post->comments_count }}</td>
                      <td class="text-center">
                        <div class="btn-option text-center">
                          <a href="" class="btn btn-primary btn-flat fa fa-pencil"></a>&nbsp;&nbsp;
                          <form method="POST" action="" class="inline">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="button" class="btn btn-danger btn-flat fa fa-trash-o btn-delete-item"
                              data-title=""
                              data-confirm="">
                            </button>
                          </form> 
                        </div>
                      </td>
                    </tr>
                  @endforeach  
                </tbody>
              </table>
              <!-- .pagination -->
              <div class="text-right">
                <nav aria-label="...">
                  <ul class="pagination">
                    {{ $posts->links() }}
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
