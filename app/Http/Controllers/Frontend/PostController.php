<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function all() {
        $posts = Post::all();
        return response()->json($posts, 200);
    }

    public function get($id) {
        $post = Post::findOrFail($id);
        return response()->json($post, 200);
    }
}
