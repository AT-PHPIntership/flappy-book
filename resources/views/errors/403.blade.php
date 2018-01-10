<!DOCTYPE html>
<html>
<head>
  <title>403 Forbidden</title>
  <meta http-equiv="refresh" content="5;url={{ route('/') }}"/>
</head>
<body>
  <h2>Forbidden</h2>
  <p>{{ $exception->getMessage() }}</p>
</body>
</html>
