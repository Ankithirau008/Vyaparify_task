<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .sidebar {
            height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: #333;
            padding: 10px 15px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .sidebar .nav-link:hover {
            background-color: #007bff;
        }

    </style>
    @stack('styles')  <!-- To add page-specific styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Laravel Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @else
                        <!-- Dashboard Button for Logged-in Users -->
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                        @elseif(Auth::user()->role === 'author')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('blog.index') }}">Dashboard</a> <!-- Or wherever you want the author's dashboard -->
                            </li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Menu -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar shadow-sm">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        @if (Auth::user()->role === 'admin')
                            <!-- Admin can see all posts -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-house-door"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/posts*') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                                    <i class="bi bi-file-earmark-text"></i> Manage Posts
                                </a>
                            </li>
                            
                            <!-- Admin can manage categories -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                                    <i class="bi bi-tags"></i> Manage Categories
                                </a>
                            </li>
                            
                            <!-- Admin can manage tags -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/tags*') ? 'active' : '' }}" href="{{ route('tags.index') }}">
                                    <i class="bi bi-tag"></i> Manage Tags
                                </a>
                            </li>
                        @else
                            <!-- Author can only see their own posts -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('author/posts*') ? 'active' : '' }}" href="{{ route('blog.index') }}">
                                    <i class="bi bi-file-earmark-text"></i> Manage My Posts
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>
            

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')  <!-- Page content will be injected here -->
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')  <!-- To add page-specific scripts -->
</body>
</html>
