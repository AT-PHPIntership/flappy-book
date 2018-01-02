<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  @include('backend.layouts.partials.styles')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  @include('backend.layouts.partials.header')
  @include('backend.layouts.partials.side-bar')
  
  @yield('content')

  @include('backend.layouts.partials.footer')
  @include('backend.layouts.partials.scripts')  
</body>
</html>
