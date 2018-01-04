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
            <form action="{{route('books.store')}}" role="form" method="POST" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-12">
                          <label for="exampleInputTitle">{{ __('Title') }}</label>
                          <input type="text" class="form-control" name="title" placeholder="{{ __('Title') }}" value="{!! old('title') !!}">
                          @if($errors->first('title')) 
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-3">
                          <label>{{ __('List Category') }}</label>
                          <select class="form-control" name="category" >
                            <option value="">option 1</option>
                            <option value="">option 2</option>
                            <option value="">option 3</option>
                            <option value="">option 4</option>
                            <option value="">option 5</option>
                          </select>
                          @if($errors->first('category')) 
                            <span class="text-danger">{{ $errors->first('category') }}</span>
                          @endif
                        </div>
                        <div class="col-xs-3">
                          <label for="exampleInputPrice">{{ __('Price') }}</label>
                          <input type="text" class="form-control" name="price" placeholder="{{ __('Price') }}" value="{!! old('price') !!}">
                           @if($errors->first('price')) 
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                          @endif
                        </div>
                         <div class="col-xs-2">
                          <label>{{ __('Unit') }}</label>
                          <select class="form-control" name="unit" >
                            <option value="">VND</option>
                            <option value="">$</option>
                            <option value="">€</option>
                            <option value="">¥</option>
                          </select>
                          @if($errors->first('unit')) 
                            <span class="text-danger">{{ $errors->first('unit') }}</span>
                          @endif
                        </div>
                        <div class="col-xs-4">
                          <label for="exampleInputIDDonator">{{ __('ID Donator') }}</label>
                          <input type="text" class="form-control" name="iddonator" placeholder="{{ __('ID Donator') }}" value="{!! old('iddonator') !!}">
                          @if($errors->first('iddonator')) 
                            <span class="text-danger">{{ $errors->first('iddonator') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputDescription">{{ __('Description') }}</label>
                      <textarea class="textarea form-control" placeholder="Place some text here" name="description">{!! old('description') !!}</textarea>
                      @if($errors->first('description')) 
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                      @endif
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-6">
                          <label for="exampleInputAuthor">{{ __('Author') }}</label>
                          <input type="text" class="form-control" name="author" placeholder="{{ __('Author') }}" value="{!! old('author') !!}">
                          @if($errors->first('author')) 
                            <span class="text-danger">{{ $errors->first('author') }}</span>
                          @endif
                        </div>
                        <div class="col-xs-6">
                          <label for="exampleInputYear">{{ __('Year') }}</label>
                          <input type="number" class="form-control" name="year" placeholder="" value="{!! old('year') !!}">
                          @if($errors->first('year')) 
                            <span class="text-danger">{{ $errors->first('year') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="form-group">
                    <label for="exampleInputFile">{{ __('Picture') }}</label>
                    <input type="file" name="picture" value="{!! old('picture') !!}">
                    @if($errors->first('picture')) 
                      <span class="text-danger">{{ $errors->first('picture') }}</span>
                    @endif
                  </div>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
                <button type="button" class="btn btn-primary" onclick="window.history.back();">{{ __('Back') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection
