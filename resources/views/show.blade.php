@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8 px-4">
    <!-- Post Title -->
    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>

    <!-- Featured Image -->
    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg shadow-lg mb-6">

    <!-- Post Content -->
    <div class="text-lg text-gray-700 leading-relaxed">
        {!! nl2br(e($post->content)) !!}
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('posts.index') }}" class="inline-block text-blue-500 hover:text-blue-700">Back to Blog List</a>
    </div>
</div>
@endsection
