<?php

use Faker\Generator as Faker;

$factory->define(Acme\Models\Message::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'user_id' => factory(Acme\Models\User::class),
    ];
});
