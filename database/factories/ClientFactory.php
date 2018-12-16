<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Client::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
    ];
});
