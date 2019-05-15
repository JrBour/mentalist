<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'article_id', 'author_id'
    ];

    public function article()
    {
        return $this->belongsTo('App\Article', 'article_id');
    }
    public function author()
    {
        return $this->belongsTo('App\Article', 'author_id');
    }
}
