@extends('backend.layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Edit Book
    </h1>
    <ol class="breadcrumb">
      <li>
        <a href="#">
          <i class="fa fa-dashboard"></i> Home</a>
      </li>
      <li class="active">Edit Book</li>
    </ol>
  </section>
  <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <form role="form" >
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">QR Code</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="QR Code">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>List Category</label>
                  <div class="row">
                    <div class="col-xs-2">
                      <select class="form-control" >
                        <option>option 1</option>
                        <option>option 2</option>
                        <option>option 3</option>
                        <option>option 4</option>
                        <option>option 5</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="row">
                    <div class="col-xs-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input type="text" class="form-control" name="qrcode" placeholder="Title">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Price</label>
                        <input type="text" class="form-control" name="price" placeholder="Price">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">ID Donator</label>
                        <input type="text" class="form-control" name="iddonator" placeholder="ID Donator">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Description</label>
                        <textarea type="textarea" class="form-control" name="description" placeholder="Description"> </textarea>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Year</label>
                        <input type="date" class="form-control" name="year" placeholder="">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Author</label>
                        <input type="text" class="form-control" name="author" placeholder="Author">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">From Person</label>
                        <input type="text" class="form-control" name="fromperson" placeholder="From Person">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <input type="file" name="image">
                  </div>
              </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
@endsection