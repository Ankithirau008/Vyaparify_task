@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8 px-4">
    <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-8">Blog Posts</h1>

    <!-- Blog List Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ($posts as $post)
            <div class="m-2 bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-105">
                <!-- Featured Image -->
                <div class="relative">
                    @if ($post->featured_image && Storage::exists('public/' . $post->featured_image))
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-32 object-cover">
                    @else
                        <img src="{{ asset('images/default-placeholder.jpg') }}" alt="No Image" class="w-full h-32 object-cover">
                    @endif
                </div>

                <div class="p-6">
                    <!-- Title -->
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ $post->title }}</h2>

                    <!-- Description -->
                    <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($post->content, 120) }}</p>

                    <!-- Categories & Tags -->
                    <div class="flex space-x-4 mb-4">
                        <span class="text-xs font-semibold text-gray-500">Categories:</span>
                        <ul class="flex space-x-2 text-xs text-gray-600">
                            @foreach ($post->categories as $category)
                                <li class="bg-blue-100 text-blue-600 px-2 py-1 rounded-full">{{ $category->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="flex space-x-4 mb-4">
                        <span class="text-xs font-semibold text-gray-500">Tags:</span>
                        <ul class="flex space-x-2 text-xs text-gray-600">
                            @foreach ($post->tags as $tag)
                                <li class="bg-green-100 text-green-600 px-2 py-1 rounded-full">{{ $tag->name }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Read More Button -->
                    <a href="{{ route('posts.show', $post->id) }}" class="inline-block text-blue-500 font-semibold hover:text-blue-700">Read More</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6 text-center">
        {{ $posts->links() }}
    </div>
</div>
@endsection
