<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     type="object",
 *     required={"title", "content", "author_id", "category_id"},
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="author_id", type="integer", description="The author of the article"),
 *      @OA\Property(property="category_id", type="integer", description="The category of the article")
 * )
 */
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

    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
