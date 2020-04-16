<?php

namespace WebDevEtc\BlogEtc\Factories;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use WebDevEtc\BlogEtc\Models\Post;

// Basic post factory, following happy path where everything is set up so posts can be seen.
$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'subtitle' => $faker->sentence,
        'meta_desc' => $faker->paragraph,
        'post_body' => $faker->paragraphs(5, true),
        'posted_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'is_published' => true,
        'short_description' => $faker->paragraph,
        'seo_title' => $faker->sentence,
        'user_id' => null,
    ];
});

// Non published state.
$factory->state(Post::class, 'not_published', [
    'is_published' => false,
]);

// Post in future.
$factory->state(Post::class, 'in_future', function (Faker $faker) {
    return [
        'posted_at' => $faker->dateTimeBetween('now', '+2 years'),
    ];
});
