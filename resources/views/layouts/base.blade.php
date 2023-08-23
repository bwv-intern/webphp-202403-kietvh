<!DOCTYPE html>
<html>
    @section('header')
        @include('layout.header')
    @show

    <!-- Product Section Begin -->

    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>

    <!-- Product Section End -->

    @section('footer')
        @include('layout.footer')
    @show
</html>
