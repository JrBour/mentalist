<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'content', 'author_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
