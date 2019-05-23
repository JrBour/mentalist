<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Like;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 30),
        'article_id' => $faker->numberBetween($min = 1, $max = 50),
    ];
});
