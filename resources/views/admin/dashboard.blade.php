@extends('admin.admin-dashboard')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 text-center">Admin Dashboard</h1>

        <div class="row text-center">
            <!-- Total Posts -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Total Posts</h4>
                        <p class="card-text display-4">{{ $postCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Total Categories</h4>
                        <p class="card-text display-4">{{ $categoryCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">Total Users</h4>
                        <p class="card-text display-4">{{ $userCount }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
