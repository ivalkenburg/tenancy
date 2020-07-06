<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Helpers\Multitenancy\Models\Tenant;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'domain' => $faker->domainName,
    ];
});

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,

    ];
});
