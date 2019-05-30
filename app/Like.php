<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     type="object",
 *     required={"article_id", "user_id"},
 *      @OA\Property(property="id", type="integer", readOnly="true"),
 *      @OA\Property(property="article", type="integer", description="The article related to like"),
 *      @OA\Property(property="user", type="integer", description="The user related to like")
 * )
 */
class Like extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'article_id', 'user_id'
    ];

    public function article()
    {
        return $this->belongsTo('App\Article', 'article_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
