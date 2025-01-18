@extends('admin.admin-dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tags</h1>

    <a href="{{ route('tags.create') }}" class="btn btn-primary mb-3">Create New Tag</a>

    @if ($tags->count())
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
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>
                                <a href="{{ route('tags.edit', $tag) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('tags.destroy', $tag) }}" method="POST" style="display:inline;">
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
        <p>No tags available. Start by <a href="{{ route('tags.create') }}">creating a new tag</a>.</p>
    @endif
</div>
@endsection
