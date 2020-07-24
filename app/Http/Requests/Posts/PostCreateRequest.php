<?php

namespace App\Http\Requests\Posts;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts,title',
            'category' => 'required',
            'content' => 'required',
            'image' => 'mimes:jpg,png,jpeg,gif,bmp'
        ];
    }

    public function getValidRequest()
    {
        $image = $this->file('image');
        $slug = Str::slug($this->input('title'));

        if (isset($image)) {

            $imageExt = $image->getClientOriginalExtension();
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $imageExt;

            if (!Storage::disk('storage')->exists('post')) {
                Storage::disk('storage')->makeDirectory('post');
            }
            if (!Storage::disk('storage')->exists('post/thumbnail')) {
                Storage::disk('storage')->makeDirectory('post/thumbnail');
            }

            $postImage = Image::make($image)->resize(null, 1060, function ($constraint){
                $constraint->aspectRatio();
            })->save('storage/post/'.$imageName);

            $thumbnail = Image::make($image)->fit(550, 550)
                ->save('storage/post/thumbnail/'.$imageName);

        } else {
            $imageName = 'default.jpg';
        }

        return [
            'user_id' => Auth::user()->getAuthIdentifier(),
            'category_id' => $this->input('category'),
            'title' => $this->input('title'),
            'slug' => $slug,
            'content' => $this->input('content'),
            'image' => $imageName,
            'is_published' => $this->input('is_published') ?? false,
            'published_at' => $this->input('published_at'),
        ];
    }
}
