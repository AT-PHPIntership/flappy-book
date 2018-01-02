<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title-page')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  @include('layout.admin.links')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  @include('layout.admin.header')
  @include('layout.admin.side-bar')
  
  @yield('content')

  @include('layout.admin.footer')
  @include('layout.admin.scripts')  
</body>
</html>
