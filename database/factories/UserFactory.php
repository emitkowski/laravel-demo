<?php

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = Hash::make('secret'),
        'remember_token' => str_random(10),
        'api_token' => str_random(25),
        'status' => 1,
    ];
});