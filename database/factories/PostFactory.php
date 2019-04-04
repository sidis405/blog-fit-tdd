<?php

use Faker\Generator as Faker;

$factory->define(Acme\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $title = $faker->sentence,
        'user_id' => factory(Acme\Models\User::class),
        'category_id' => factory(Acme\Models\Category::class),
        'created_at' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now')
    ];
});
