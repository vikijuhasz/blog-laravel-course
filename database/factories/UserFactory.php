<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$O0EPwKRBWFO/3Q0jDQoBHuzcwPlZqtnQnI1VY9WblMP2uR3xS.Jue', // password
        'remember_token' => Str::random(10),
        'is_admin' => false
    ];
});

$factory->state(User::class, 'john-doe', function (Faker $faker) {
    return [
        'name' => 'John Doe',
        'email' => 'john@laravel.test',
        'is_admin' => true
    ];
});
