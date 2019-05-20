<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @OA\Schema(
 *     type="object",
 *     required={"firstname", "username", "name", "email", "password"},
 *      @OA\Property(property="id", type="integer", readOnly="true"),
 *      @OA\Property(property="firstname", type="string"),
 *      @OA\Property(property="username", type="string"),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="email", type="string"),
 *      @OA\Property(property="email_hashed", type="string", readOnly="true"),
 *      @OA\Property(property="password", type="string")
 * )
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'firstname', 'username', 'admin', 'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles()
    {
        return $this->hasMany('App\Article');
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
