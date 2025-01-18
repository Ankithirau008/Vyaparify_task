<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/posts*') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                    Manage Posts
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    Manage Categoriesss
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/tags*') ? 'active' : '' }}" href="#">
                    Manage Tags
                </a>
            </li>
        </ul>
    </div>
</nav>