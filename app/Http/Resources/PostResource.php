<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => Str::limit($this->content, 50, $end='...'),
            'image' => $this->image,
            'is_publish' => $this->is_publish,
            'is_deleted' => $this->is_deleted,
            'created_at' => $this->created_at->format('d-m-Y H:i:s')
        ];
    }
}
