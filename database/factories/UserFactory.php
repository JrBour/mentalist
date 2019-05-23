<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $email = $faker->unique()->safeEmail;
    return [
        'name' => $faker->name,
        'firstname' => $faker->firstName,
        'admin' => $faker->boolean($chanceOfGettingTrue = 50),
        'username' => $faker->userName,
        'email' => $email,
        'email_hashed' => md5( strtolower( trim($email ))),
        'password' => Hash::make('admin'),
        'remember_token' => Str::random(10),
    ];
});
