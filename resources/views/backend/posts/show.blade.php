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
        <a href="#">
          <i class="fa fa-dashboard"></i>{{ __('posts.home') }}</a>
      </li>
      <li>
        <a href="#">{{ __('posts.posts') }}</a>
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
          <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{ asset('bower_components/admin-lte/dist/img/user4-128x128.jpg') }}" alt="User profile picture">

            <h3 class="profile-username text-center">Nina Mcintire</h3>

            <p class="text-muted text-center">PHP Developer</p>

            <ul class="list-group list-group-unbordered">
              <li class="list-group-item">
                <b>{{ __('posts.status') }}</b>
                <a class="pull-right">Reivew</a>
              </li>
              <li class="list-group-item">
                <b>{{ __('posts.rating') }}</b>
                <a class="pull-right">4.5</a>
              </li>
              <li class="list-group-item">
                <b>{{ __('posts.like') }}</b>
                <a class="pull-right">23</a>
              </li>
              <li class="list-group-item">
                <b>{{ __('posts.create_date') }}</b>
                <a class="pull-right">2018-01-24</a>
              </li>
              {{--  <li class="list-group-item">  --}}
                <b style="padding-top: 50px">{{ __('posts.content') }}</b>
              {{--  </li>  --}}
              {{--  <li class="list-group-item">  --}}
                <p>Lorem ipsum represents a long-held tradition for designers, typographers and the like. Some people hate it and argue for its demise, but others ignore the hate as they create awesome tools to help create filler text for everyone from bacon lovers to Charlie Sheen fans.</p>
              {{--  </li>  --}}
            </ul>

            <a href="#" class="btn btn-danger btn-block btn-flat">
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
                  <th>{{ __('posts.content') }}</th>
                  <th class="text-center">{{ __('posts.comment_date') }}</th>
                  <th class="text-center">{{ __('posts.options') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td class="text-center">1</td>
                  <td>This is comment number 1</td>
                  <td class="text-center">Win 95+</td>
                  <td class="text-center" width="15%">
                    <a href="#" class="btn btn-danger btn-flat fa fa-trash-o"></a>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">2</td>
                  <td><i class="fa fa-mail-reply fa-rotate-180">&nbsp;&nbsp;&nbsp;&nbsp;</i>&nbsp;&nbsp;This is comment child of comment number 1</td>
                  <td class="text-center">Win 95+</td>
                  <td class="text-center" width="15%">
                    <a href="#" class="btn btn-danger btn-flat fa fa-trash-o"></a>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">3</td>
                  <td><i class="fa fa-mail-reply fa-rotate-180">&nbsp;&nbsp;&nbsp;&nbsp;</i>&nbsp;&nbsp;This is comment child of comment number 1</td>
                  <td class="text-center">Win 95+</td>
                  <td class="text-center" width="15%">
                    <a href="#" class="btn btn-danger btn-flat fa fa-trash-o"></a>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">4</td>
                  <td>This is comment number 2</td>
                  <td class="text-center">Win 95+</td>
                  <td class="text-center" width="15%">
                    <a href="#" class="btn btn-danger btn-flat fa fa-trash-o"></a>
                  </td>
                </tr>
              </table>
              <div class="text-right">
                <ul class="pagination">
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
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
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </section>
  <!-- /.content -->
</div>
@endsection
