<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Platinum Store</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    @include('layouts.navbar')
    <div class="container">
      @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>