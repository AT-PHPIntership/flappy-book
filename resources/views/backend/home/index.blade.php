@extends('backend.layouts.master') 
@section('title') 
{{ __('dashboard.dashboard') }} 
@endsection 
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      {{ __('dashboard.dashboard') }}
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="#">
          <i class="fa fa-dashboard"></i> {{ __('dashboard.home') }}</a>
      </li>
      <li class="active">{{ __('dashboard.dashboard') }}</li>
      </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{ __('dashboard.books') }}</span>
            <span class="info-box-number">{{ $books }}</span>
            <a href="{{ route('books.index') }}" class="small-box-footer">{{ __('dashboard.more_info') }}
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-purple"><i class="fa fa-credit-card"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{ __('dashboard.borrows') }}</span>
            <span class="info-box-number">{{ $borrows }}</span>
            <a href="{{ route('borrows.index') }}" class="small-box-footer">{{ __('dashboard.more_info') }}
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>       
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{ __('dashboard.users') }}</span>
            <span class="info-box-number">{{ $users }}</span>
            <a href="{{ route('users.index') }}" class="small-box-footer">{{ __('dashboard.more_info') }}
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-tags"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{ __('dashboard.posts') }}</span>
            <span class="info-box-number">{{ $posts }}</span>
            <a href="{{ route('posts.index') }}" class="small-box-footer">{{ __('dashboard.more_info') }}
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-navy"><i class="fa fa-tasks"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">{{ __('dashboard.categories') }}</span>
            <span class="info-box-number">{{ $categories }}</span>
            <a href="{{ route('categories.index') }}" class="small-box-footer">{{ __('dashboard.more_info') }}
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="margin-top: 30px">
      <div class="col-md-6 text-center">
        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">{{ __('dashboard.top_5_borrowed')}}</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="bar-chart" style="height:280px"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<!-- /.content -->
</div>
@section('script') 
<script>
  var barChartData = {
    labels : [
      @foreach ($topBorrowed as $borrow)
        "{!! $borrow->title !!}",
      @endforeach 
    ],
    datasets : [
      {
        fillColor : "rgba(220, 220, 220,0.5)",
        strokeColor : "rgba(134, 202, 75,0.8)",
        highlightFill: "rgba(220, 220, 220,0.75)",
        highlightStroke: "rgba(134, 202, 75,1)",
        data : [
          @foreach ($topBorrowed as $borrow)
            "{!! $borrow->total_borrowed !!}",
          @endforeach 
        ]
      }
    ]
  }
  window.onload = function(){
    var ctx = document.getElementById("bar-chart").getContext("2d");
    window.myBar = new Chart(ctx).Bar(barChartData, {
      responsive : true
    });
  }
</script>
@endsection 
@endsection
