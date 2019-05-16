<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     type="object",
 *     required={"name"},
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="name", type="string")
 * )
 */
class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    public function articles()
    {
        return $this->hasMany('App\Article');
    }
}
