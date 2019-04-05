<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(Acme\Models\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        //'role' => 'user',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->state(Acme\Models\User::class, 'utente_con_contratto_da_firmare', [
    'con_contratto' => '1',
    'firmato' => '0',
]);

$factory->afterCreatingState(Acme\Models\User::class, 'utente_con_contratto_da_firmare', function ($user, $faker) {
    $contratto = factory(Acme\Models\Contratto::class)->states('da_firmare')->create([
        'user_id' => $user->id
    ]);

    factory(Acme\Models\RichiestAFirma::class)->states('default')->create([
        'contratto_id' => $contratto->id
    ]);
});
