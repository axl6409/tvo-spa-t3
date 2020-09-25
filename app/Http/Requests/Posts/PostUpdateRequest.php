<?php

namespace App\Http\Requests\Posts;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostUpdateRequest extends FormRequest
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
            'title' => 'required|max:250',
            'category' => 'required',
            'content' => 'required'
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

            if (!Storage::disk('public')->exists('post')) {
                Storage::disk('public')->makeDirectory('post');
            }
            if (!Storage::disk('public')->exists('post/thumbnail')) {
                Storage::disk('public')->makeDirectory('post/thumbnail');
            }

            $path = "images/";

            $postImage = Image::make($image)->resize(null, 1060, function ($constraint){
                $constraint->aspectRatio();
            })->save(public_path($path).'post/'.$imageName);

            $thumbnail = Image::make($image)->fit(550, 550)
                ->save(public_path($path).'post/thumbnail/'.$imageName);

        } else {
            $imageName = $this->input('image');
        }

        return [
            'user_id' => Auth::user()->getAuthIdentifier(),
            'category_id' => $this->input('category'),
            'title' => $this->input('title'),
            'slug' => $slug,
            'content' => $this->input('content'),
            'image' => $imageName,
            'is_published' => $this->input('is_published') ?? false,
        ];
    }
}
