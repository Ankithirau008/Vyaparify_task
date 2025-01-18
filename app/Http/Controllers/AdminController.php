<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;


class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'postCount' => Post::count(),
            'categoryCount' => Category::count(),
            'userCount' => User::count(),
        ]);
    }

}
