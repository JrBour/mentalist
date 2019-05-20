<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'content' => $faker->text,
        'author_id' => $faker->numberBetween($min = 1, $max = 30),
        'category_id' => $faker->numberBetween($min = 1, $max = 30)
    ];
});
