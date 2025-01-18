@extends('admin.admin-dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Categories</h1>

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>

    @if ($categories->count())
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No categories available. Start by <a href="{{ route('categories.create') }}">creating a new category</a>.</p>
    @endif
</div>
@endsection
