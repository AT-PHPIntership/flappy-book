<!DOCTYPE html>
<html>
<head>
  <title>{{ __('403.403_forbidden')}}</title>
  <meta http-equiv="refresh" content="5;url={{ route('home') }}"/>
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
</head>
<body>
  <div class="col-md-8">
    <h1>{{ __('403.forbidden') }}</h1>
    <h2 class="text-danger">{{ $exception->getMessage() }}</h2>
    <h3><a  class="col-sm-3" href="javascript:history.back()" title="">{{ __('403.go_back') }}</a></h3>
    <h3><a href="{{ route('home') }}" title="">{{ __('403.go_to_home_pages') }}</a></h3>
  </div>
</body>
</html>
