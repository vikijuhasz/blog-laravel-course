<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BlogPost;
use App\Profile;
use Faker\Generator as Faker;

$factory->define(BlogPost::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(10),
        'content' => $faker->paragraphs(3, true),
        'created_at' => $faker->dateTimeBetween('-3 months')
    ];
});

$factory->state(BlogPost::class, 'new-title', function (Faker $faker) {
    return [
        'title' => 'New Title'
    ];
});

$factory->afterCreating(App\Author::class, function ($author, $faker) {
	$author->profile()->save(factory(Profile::class)->make());
});	
