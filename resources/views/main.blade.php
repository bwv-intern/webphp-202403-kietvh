<html>
<head>
    <title>Hello</title>
</head>

<body class="container">

<header>
    <h1>Hello world</h1>
</header>

<div class="main">
    @yield('content')
</div>

<div class="footer clearfix">
    @yield('footer')
</div>


@yield('script')


</body>
</html>
