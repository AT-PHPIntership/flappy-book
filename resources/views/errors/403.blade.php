<!DOCTYPE html>
<html>
<head>
  <title>{{ __('403 Forbidden ')}}</title>
  <meta http-equiv="refresh" content="5;url={{ route('home') }}"/>
</head>
<body>
  <h2>{{ __('Forbidden') }}</h2>
  <p>{{ $exception->getMessage() }}</p>
</body>
</html>
