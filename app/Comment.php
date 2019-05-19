<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     type="object",
 *     required={"content", "article_id", "author_id"},
 *      @OA\Property(property="id", type="integer", readOnly="true"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="article_id", type="integer", description="The article related to comment"),
 *      @OA\Property(property="author_id", type="integer", description="The author of the comment")
 * )
 */
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
