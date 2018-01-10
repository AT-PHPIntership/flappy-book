<!DOCTYPE html>
<html>
<head>
  <title>{{ __('403 Forbidden ')}}</title>
  <meta http-equiv="refresh" content="5;url={{ route('home') }}"/>
  <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
</head>
<body>
  <div class="col-md-8">
    <h1>{{ __('Forbidden') }}</h1>
    <h2 class="text-danger">{{ $exception->getMessage() }}</h2>
    <h3><a  class="col-sm-3" href="javascript:history.back()" title="">{{ __('Go back') }}</a></h3>
    <h3><a href="{{ route('home') }}" title="">{{ __('Go to home page') }}</a></h3>
  </div>
</body>
</html>
