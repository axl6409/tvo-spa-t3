<?php

namespace App\Http\Controllers\FrontEnd;

use App\Category;
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

    public  function byCategory($id) {
        $posts = Post::all();
        $datas = $posts->where('category_id', $id);
        return response()->json($datas, 200);
    }
}
