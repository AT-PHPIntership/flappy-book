@extends('backend.layouts.master')

@section('title') 
  {{ __('posts.detail_post') }}
@endsection 

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      {{ __('posts.detail_post') }}
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="{{ route('admin.home.index')}} ">
          <i class="fa fa-dashboard"></i>{{ __('posts.home') }}</a>
      </li>
      <li>
        <a href="{{ route('posts.index') }}">{{ __('posts.posts') }}</a>
      </li>
      <li class="active">{{ __('posts.detail') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-4">
        <!-- Profile Image -->
        <div class="box box-primary">
          @include('backend.layouts.partials.modal')
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ $post->avatar_url }}" alt="User profile picture">
            <h3 class="profile-username text-center">{{ $post->name }}</h3>
            <p class="text-muted text-center">{{ $post->team }}</p>
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>{{ __('posts.status') }}</b>
                @foreach( __('posts.liststatus') as $key => $status )
                  @if($key == $post->status)
                    <a class="pull-right">{{ $status }}</a>                    
                  @endif
                @endforeach
              </li>
              @if ($post->status == App\Model\Post::TYPE_REVIEW_BOOK)
                <li class="list-group-item">
                  <b>{{ __('posts.book') }}</b>
                  <a class="pull-right">{{ $post->title }}</a>
                </li>
                <li class="list-group-item">
                  <b>{{ __('posts.rating') }}</b>
                  <a class="pull-right">{{ $post->rating }}</a>
                </li>
              @endif
              <li class="list-group-item">
                <b>{{ __('posts.like') }}</b>
                <a class="pull-right">{{ $post->likes }}</a>
              </li>
              <li class="list-group-item">
                <b>{{ __('posts.create_date') }}</b>
                <a class="pull-right">{{ date(config('define.posts.format_date_detail_post'), strtotime($post->created_at)) }}</a>
              </li>
              <div style="padding-top: 10px;"><b>{{ __('posts.content') }}</b></div>
              <p>{!! $post->content !!}</p>
            </ul>
            <a href="#" class="btn btn-danger btn-block btn-flat btn-delete-item" data-title="{{ __('common.confirm.title') }}" data-confirm="{{ __('common.confirm.delete_post') }}">
              <b>{{ __('posts.delete') }}</b>
            </a>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-8">
        <div class="nav-tabs-custom">
          <div class="tab-content box box-primary">
            <div class="box-header">
              <h3 class="box-title">{{ __('posts.list_comments') }}</h3>
            </div>
            <div class="box-body">
              <table id="list-comments" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th class="text-center" width="10%">{{ __('posts.id') }}</th>
                  <th width="50%">{{ __('posts.content') }}</th>
                  <th class="text-center">{{ __('posts.comment_date') }}</th>
                  <th class="text-center">{{ __('posts.options') }}</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($comments as $comment)
                    @if ($comment->parent_id == null)
                      <tr>
                        <td class="text-center">{{ $comment->id }}</td>
                        <td>{!! $comment->comment !!}</td>
                        <td class="text-center">{{ date(config('define.posts.format_date_detail_post'), strtotime($comment->created_at)) }}</td>
                        <td class="text-center" width="15%">
                          <a href="#" class="btn btn-danger btn-flat fa fa-trash-o"></a>
                        </td>
                      </tr>
                      @foreach ($comment->comments as $index => $childComment)
                        <tr>
                          <td class="text-right">{{ $comment->id }}.{{ ++$index }}</td>
                          <td>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-level-up fa-rotate-90"></i>&nbsp;&nbsp;{!! $childComment->comment !!}</td>
                          <td class="text-center">{{ date(config('define.posts.format_date_detail_post'), strtotime($childComment->created_at)) }}</td>
                          <td class="text-center" width="15%">
                            <a href="#" class="btn btn-danger btn-flat fa fa-trash-o"></a>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  @endforeach                  
                </tbody>
              </table>
              <div class="text-right">
                {{ $comments->links() }}
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
          <!-- /.tab-content -->
      </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
@endsection
