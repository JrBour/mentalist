<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'article_id', 'user_id'
    ];

    public function article()
    {
        return $this->belongsTo('App\Article');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
