<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;


class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->orderBy('id', 'desc')->paginate(5);
        return view('frontend.home', compact('posts'));
    }
}
