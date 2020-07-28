<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'content' => $this->content,
            'image' => $this->image,
            'is_publish' => $this->created_at,
            'is_deleted' => $this->updated_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
