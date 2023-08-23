<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/lib/bootstrap/bootstrap.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/lib/font-awesome/all.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/jquery/jquery-ui.min.css') }}" type="text/css">

    @yield('style')

    <script src="{{ asset('js/jquery/jquery-3.7.js') }}"></script>
    <script src="{{ asset('js/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/jquery-validation/custom-messages.js') }}"></script>
</head>
