<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <li class="nav-item" style="padding: 10px;">
                <p>{{ auth()->user()->name ?? null }}</p>
            </li>
            <li class="nav-item" style="padding: 10px;">
                <x-nav-link :to="route('logout')">
                    <p>Logout</p>
                </x-nav-link>
            </li>
        </li>
    </ul>
</nav>
