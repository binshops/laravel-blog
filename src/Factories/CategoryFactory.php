<?php

namespace WebDevEtc\BlogEtc\Factories;

/* @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use WebDevEtc\BlogEtc\Models\Category;

$factory->define(Category::class, static function (Faker $faker) {
    return [
        'category_name' => $faker->sentence,
        'slug' => Str::slug($faker->sentence),
        'category_description' => $faker->paragraph,
    ];
});
