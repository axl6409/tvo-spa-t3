<?php

namespace App\Http\Requests\Medias;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use function foo\func;

class MediaCreateRequest extends FormRequest
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
            'name' => 'required|unique:medias,name',
            'description' => 'required',
            'path' => 'required',
            'image' => 'mimes:jpg,png,jpeg,gif,bmp'
        ];
    }

    public function getValidRequest()
    {
        $image = $this->file('image');
        $slug = Str::slug($this->input('name'));

        if (isset($image)) {

            $imageExt = $image->getClientOriginalExtension();
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug . '-' . $currentDate . '-' . uniqid() . '.' . $imageExt;

            if (!Storage::disk('storage')->exists('medias')) {
                Storage::disk('storage')->makeDirectory('medias');
            }
            if (!Storage::disk('storage')->exists('medias/thumbnail')) {
                Storage::disk('storage')->makeDirectory('medias/thumbnail');
            }

            $postImage = Image::make($image)->resize(null, 1060, function ($constraint){
                $constraint->aspectRatio();
            })->save('storage/medias/'.$imageName);

            $thumbnail = Image::make($image)->fit(550, 550)
                ->save('storage/medias/thumbnail/'.$imageName);

        } else {
            $imageName = 'default.jpg';
        }

        return [
            'name' => $this->input('name'),
            'slug' => $slug,
            'description' => $this->input('description'),
            'path' => $imageName,
        ];
    }
}
