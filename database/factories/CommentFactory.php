<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->text,
        'author_id' => $faker->numberBetween($min = 1, $max = 30),
        'article_id' => $faker->numberBetween($min = 1, $max = 50),
    ];
});

