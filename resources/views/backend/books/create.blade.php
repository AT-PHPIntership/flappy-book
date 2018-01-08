@extends('backend.layouts.master')
@section('title')
    {{ __('books.create_book') }}
@endsection
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      {{ __('books.create_book') }}
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="#">
          <i class="fa fa-dashboard"></i> {{ __('books.home') }}</a>
      </li>
      <li><a href="">{{ __('books.books') }}</a></li>
      <li class="active">{{ __('books.create_book') }}</li>
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
                          <label for="exampleInputTitle">{{ __('books.title') }}</label>
                          <input type="text" class="form-control" name="title" placeholder="{{ __('books.Title') }}" value="{!! old('title') !!}">
                          @if($errors->first('title')) 
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-3">
                          <label>{{ __('books.category') }}</label>
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
                          <label for="exampleInputPrice">{{ __('books.price') }}</label>
                          <input type="text" class="form-control" name="price" placeholder="{{ __('books.Price') }}" value="{!! old('price') !!}">
                           @if($errors->first('price')) 
                            <span class="text-danger">{{ $errors->first('price') }}</span>
                          @endif
                        </div>
                         <div class="col-xs-2">
                          <label>{{ __('books.unit') }}</label>
                          <select class="form-control" name="unit" >
                              @foreach( __('books.listunit') as $key => $unit )
                              <option value="{{ $key }}">{{ $unit }}</option>
                              @endforeach
                          </select>
                          @if($errors->first('unit')) 
                            <span class="text-danger">{{ $errors->first('unit') }}</span>
                          @endif
                        </div>
                        <div class="col-xs-4">
                          <label for="exampleInputIDDonator">{{ __('books.id_donator') }}</label>
                          <input type="text" class="form-control" name="iddonator" placeholder="{{ __('books.ID_Donator') }}" value="{!! old('iddonator') !!}">
                          @if($errors->first('iddonator')) 
                            <span class="text-danger">{{ $errors->first('iddonator') }}</span>
                          @endif
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputDescription">{{ __('books.description') }}</label>
                      <textarea class="textarea form-control" placeholder="{{ __('books.place_some_text_here') }}" name="description">{!! old('description') !!}</textarea>
                      @if($errors->first('description')) 
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                      @endif
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-xs-6">
                          <label for="exampleInputAuthor">{{ __('books.author') }}</label>
                          <input type="text" class="form-control" name="author" placeholder="{{ __('books.Author') }}" value="{!! old('author') !!}">
                          @if($errors->first('author')) 
                            <span class="text-danger">{{ $errors->first('author') }}</span>
                          @endif
                        </div>
                        <div class="col-xs-6">
                          <label for="exampleInputYear">{{ __('books.year') }}</label>
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
                    <label for="exampleInputFile">{{ __('books.picture') }}</label>
                    <input type="file" name="picture" value="{!! old('picture') !!}">
                    @if($errors->first('picture')) 
                      <span class="text-danger">{{ $errors->first('picture') }}</span>
                    @endif
                  </div>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">{{ __('books.create') }}</button>&nbsp;&nbsp;
                <button type="button" class="btn btn-flat " onclick="window.history.back();">{{ __('books.back') }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection
