@extends('backend.layouts.master')
@section('title')
    {{ __('books.edit_book') }}
@endsection
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      {{ __('books.edit_book') }}
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="#">
          <i class="fa fa-dashboard"></i> {{ __('books.home') }}</a>
      </li>
      <li class=""><a href="">{{ __('books.books') }}</a></li>
      <li class="active">{{ __('books.edit_book') }}</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <form action="{{route('books.update', 2)}}" role="form" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="box-body">
              <div class="row">
                <div class="col-xs-12">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-12">
                        <label for="InputTitle">{{ __('books.title') }}</label>
                        <input type="text" class="form-control" name="title" id="InputTitle" placeholder="{{ __('books.title') }}" value="{{ $book->title }}">
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
                        <select class="form-control" name="category_id" >
                          @foreach($categories as $category)
                            @if($book->category_id == $category->id)
                              <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                            @else
                              <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endif
                          @endforeach
                        </select>
                        @if($errors->first('category')) 
                          <span class="text-danger">{{ $errors->first('category') }}</span>
                        @endif
                      </div>
                      <div class="col-xs-3">
                        <label for="InputPrice">{{ __('books.price') }}</label>
                        <input type="text" class="form-control" name="price" id="InputPrice" placeholder="{{ __('books.price') }}" value="{{ $book->price }}">
                        @if($errors->first('price')) 
                          <span class="text-danger">{{ $errors->first('price') }}</span>
                        @endif
                      </div>
                      <div class="col-xs-2">
                        <label>{{ __('books.unit') }}</label>
                        <select class="form-control" name="unit" >
                          @foreach( __('books.listunit') as $key => $unit )
                            @if($unit == $book->unit)
                              <option value="{{ $key }}" selected>{{ $unit }}</option>
                            @else
                              <option value="{{ $key }}">{{ $unit }}</option>
                            @endif
                          @endforeach
                        </select>
                        @if($errors->first('unit')) 
                          <span class="text-danger">{{ $errors->first('unit') }}</span>
                        @endif
                      </div>
                      <div class="col-xs-4">
                        <label for="InputFromPerson">{{ __('books.from_person') }}</label>
                        <input type="text" class="form-control" id="InputFromPerson" name="from_person" placeholder="{{ __('books.from_person') }}" value="{!! $book->from_person !!}">
                        @if($errors->first('from_person')) 
                          <span class="text-danger">{{ $errors->first('from_person') }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="InputDescription">{{ __('books.description') }}</label>
                    <textarea class="textarea form-control" placeholder="{{ __('books.place_some_text_here') }}" name="description" id="InputDescription">{!! $book->description !!}</textarea>
                    @if($errors->first('description')) 
                      <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-xs-6">
                        <label for="InputAuthor">{{ __('books.author') }}</label>
                        <input type="text" class="form-control" name="author" id="InputAuthor" placeholder="{{ __('books.author') }}" value="{{ $book->author }}">
                        @if($errors->first('author')) 
                          <span class="text-danger">{{ $errors->first('author') }}</span>
                        @endif
                      </div>
                      <div class="col-xs-6">
                        <label for="InputYear">{{ __('books.year') }}</label>
                        <input type="number" class="form-control" name="year" id="InputYear" placeholder="" value="{{ $book->year }}">
                        @if($errors->first('year')) 
                          <span class="text-danger">{{ $errors->first('year') }}</span>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="InputFile">{{ __('books.picture') }}</label>
                <input type="file" name="picture" id="picture">
                @if($errors->first('picture')) 
                  <span class="text-danger">{{ $errors->first('picture') }}</span>
                @endif
                @if(isset($book->picture))
                  <img id="picture-display" width="150" height="200" src="{{ $book->picture }}" alt="book-picture">
                @endif
              </div>
            </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-flat">{{ __('books.update') }}</button>&nbsp;&nbsp;
              <button type="button" class="btn btn-flat " onclick="window.history.back();">{{ __('books.back') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
