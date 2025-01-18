<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
    
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published', // Validate status field
            'category_ids' => 'required|array',
            'tag_ids' => 'required|array',
        ]);

        $post = new Post($request->only('title', 'content', 'status'));
        $post->user_id = auth()->id(); 
        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('public/images');
        }

        $post->save();

        $post->categories()->attach($request->category_ids);
        $post->tags()->attach($request->tag_ids);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
    
        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required|in:draft,published', 
            'category_ids' => 'required|array',
            'tag_ids' => 'required|array',
        ]);

        $post->update($request->only('title', 'content', 'status'));
        if ($request->hasFile('featured_image')) {
            $post->featured_image = $request->file('featured_image')->store('public/images');
        }

        $post->categories()->sync($request->category_ids);
        $post->tags()->sync($request->tag_ids);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function approve(Post $post)
    {
        $post->approval_status = 'approved';
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post approved successfully.');
    }
    
    public function disapprove(Post $post)
    {
        $post->approval_status = 'pending';  // or 'rejected' depending on your business logic
        $post->save();
    
        return redirect()->route('posts.index')->with('success', 'Post disapproved successfully.');
    }
    
    public function list()
    {
        $posts = Post::where(['status'=> 'published','approval_status'=>'approved'])->paginate(6); // Show 6 posts per page
        return view('welcome', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('show', compact('post'));
    }

}
