@extends('admin.admin-dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create New Tag</h1>

    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection
