<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = "medias";

    protected $guarded = [];

    protected $fillable = ['name', 'slug', 'description', 'path'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
