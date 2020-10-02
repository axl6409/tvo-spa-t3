<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Category;
use App\Http\Requests\Posts\PostCreateRequest;
use App\Http\Requests\Posts\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.admin.posts.edit', compact( 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        $post = Post::create($request->getValidRequest());
        return response()->json('Post Created !', 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if($request->image !== $post->image) {
            $postImage = $post->image;
            Storage::disk('public')->delete('post/'. $postImage);
            Storage::disk('public')->delete('post/thumbnail/'. $postImage);
        }
        $post->update($request->getValidRequest());
        return response()->json($request, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $postImage = $post->image;
        if($postImage) {
            Storage::disk('public')->delete('post/'.$postImage);
            Storage::disk('public')->delete('post/thumbnail/'.$postImage);
        }
        $post->delete($id);
        return response()->json('Deleted !', 200);
    }

    /**
     * Set the post to publish status
     *
     * @param $id
     */
    public function publish($id) {
        $post = Post::findOrFail($id);
        if ($post->is_publish === 0) {
            $post->update(array('is_publish' => '1'));
            return response()->json('1', 200);
        } else {
            $post->update(array('is_publish' => '0'));
            return response()->json('0', 200);
        }
    }
}
