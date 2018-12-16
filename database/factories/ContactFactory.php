<?php

use App\Model\Client;
use App\Model\Contact;
use Faker\Generator as Faker;
use Faker\Provider\Address;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'client_id' => function() {
            return Client::all()->random();
        },
        'address' => $faker->streetAddress,
        'postcode' => Address::postcode()
    ];
});
