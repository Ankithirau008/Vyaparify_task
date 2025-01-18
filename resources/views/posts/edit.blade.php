@extends('admin.admin-dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Post</h1>

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" rows="5" class="form-control" required>{{ $post->content }}</textarea>
        </div>

        <!-- Status Field -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Published</option>
            </select>
        </div>

        <!-- Categories Field -->
        <div class="mb-3">
            <label for="category_ids" class="form-label">Categories</label>
            <select name="category_ids[]" id="category_ids" class="form-control select2" multiple required>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Tags Field -->
        <div class="mb-3">
            <label for="tag_ids" class="form-label">Tags</label>
            <select name="tag_ids[]" id="tag_ids" class="form-control select2" multiple required>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" 
                        {{ in_array($tag->id, $post->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="featured_image" class="form-label">Featured Image</label>
            <input type="file" name="featured_image" id="featured_image" class="form-control">
            @if ($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="img-thumbnail mt-2" style="max-height: 150px;">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<!-- Initialize Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2(); // Initialize Select2 for all select elements with the class 'select2'
    });
</script>
@endsection
