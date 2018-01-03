@extends('backend.layouts.master')
@section('title')
    {{ __('Dashboard') }}
@endsection
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      {{ __('Create Book') }}
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="#">
          <i class="fa fa-dashboard"></i> {{ __('Home') }}</a>
      </li>
      <li class="active">{{ __('Books') }}</li>
    </ol>
  </section>
  <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <form role="form" method="" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label>{{ __('List Category') }}</label>
                  <div class="row">
                    <div class="col-xs-2">
                      <select class="form-control" name="category" >
                        <option value="">option 1</option>
                        <option value="">option 2</option>
                        <option value="">option 3</option>
                        <option value="">option 4</option>
                        <option value="">option 5</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="row">
                    <div class="col-xs-6">
                      <div class="form-group">
                        <label for="exampleInputTitle">{{ __('Title') }}</label>
                        <input type="text" class="form-control" name="title" placeholder="{{ __('Title') }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPrice">{{ __('Price') }}</label>
                        <input type="text" class="form-control" name="price" placeholder="{{ __('Price') }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputIDDonator">{{ __('ID Donator') }}</label>
                        <input type="text" class="form-control" name="iddonator" placeholder="{{ __('ID Donator') }}">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputDescription">{{ __('Description') }}</label>
                        <textarea class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputYear">{{ __('Year') }}</label>
                        <input type="number" class="form-control" name="year" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputAuthor">{{ __('Author') }}</label>
                        <input type="text" class="form-control" name="author" placeholder="{{ __('Author') }}">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">{{ __('Image') }}</label>
                    <input type="file" name="image">
                  </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                <button type="reset" class="btn btn-primary">{{ __('Reset') }}</button>
                <button type="button" class="btn btn-primary" onclick="window.history.back();">{{ __('Back') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection
