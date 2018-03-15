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
    @include('flash::message')
    <div id="message"></div>
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
                @switch($post->status)
                  @case(config('define.posts.type_review_book'))
                    <a class="pull-right">{{ __('posts.review') }}</a>
                    @break
                  @case(config('define.posts.type_status'))
                    <a class="pull-right">{{ __('posts.status') }}</a>
                    @break
                  @case(config('define.posts.type_find_book'))
                    <a class="pull-right">{{ __('posts.find_book') }}</a>
                    @break
                @endswitch
              </li>
              @if ($post->status == config('define.posts.type_review_book'))
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
                <a class="pull-right">{{ $post->create_date }}</a>
              </li>
              <div style="padding-top: 10px;"><b>{{ __('posts.content') }}</b></div>
              <p>{!! $post->content !!}</p>
            </ul>
            <form method="POST" action="{{ route('posts.destroy', [$post->id, 'page' => request('page') ?? 1]) }}">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button type="button" class="btn btn-danger btn-block btn-flat btn-delete-item" data-title="{{ __('common.confirm.title') }}" data-confirm="{{ __('common.confirm.delete_post') }}">
                <b>{{ __('posts.delete') }}</b>
              </button>
            </form>
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
                  <th width="60%">{{ __('posts.content') }}</th>
                  <th class="text-center">{{ __('posts.comment_date') }}</th>
                  <th class="text-center">{{ __('posts.options') }}</th>
                </tr>
                </thead>
                <tbody>
                  {!! showComment($comments) !!}
                </tbody>
              </table>
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
@section('script')
<script src="{{ asset('js/dataTable-in-detail-post.js') }}"></script>
@endsection
