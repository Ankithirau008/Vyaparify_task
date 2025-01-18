@extends('admin.admin-dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Your Posts</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

    @if ($posts->count())
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Featured Image</th>
                    <th>Status</th>
                    <th>Approval Status</th> <!-- Added column for approval status -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $loop->iteration + ($posts->currentPage() - 1) * $posts->perPage() }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($post->content, 50) }}</td>
                        <td>
                            @if ($post->featured_image && Storage::exists('public/' . $post->featured_image))
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" style="max-height: 50px; max-width: 50px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-placeholder.jpg') }}" alt="No Image" style="max-height: 50px; max-width: 50px; object-fit: cover;">
                            @endif
                        </td>
                        <td>{{ ucfirst($post->status) }}</td>
                        <td>{{ ucfirst($post->approval_status) }}</td> <!-- Display approval status -->

                        <td>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Approve and Disapprove buttons based on approval status -->
                            @if (Auth::user()->role === 'admin')

                            @if($post->approval_status === 'pending')
                                <form action="{{ route('posts.approve', $post) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                            @elseif($post->approval_status === 'approved')
                                <form action="{{ route('posts.disapprove', $post) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Disapprove</button>
                                </form>
                            @endif
                            @endif

                            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
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

    <div class="mt-4">
        {{ $posts->links() }} <!-- Pagination -->
    </div>
    @else
        <p>No posts available. Start by <a href="{{ route('posts.create') }}">creating a new post</a>.</p>
    @endif
</div>
@endsection
