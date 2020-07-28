<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    protected $fillable = ['user_id', 'category_id', 'title', 'slug', 'content', 'image', 'is_publish', 'deleted_at', 'published_at'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function medias()
    {
        return $this->belongsToMany(Media::class);
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
