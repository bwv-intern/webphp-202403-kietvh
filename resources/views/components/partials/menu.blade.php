<!-- Sidebar -->
<aside class="main-sidebar border bg-gradient-white">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-sidebar flex-column pt-5">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/user*') ? 'text-decoration-underline active' : '' }}"
                        href="{{ route('admin.userList') }}">User List</a>
                </li>
                @if (Auth::check() && Auth::user()->position == 0)
                    <li class="nav-item">
                        <a class="nav-link  {{ request()->is('admin/group*') ? ' text-decoration-underline active' : '' }}"
                            href="{{ route('admin.groupList') }}">Group List</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
<!-- /Sidebar -->
