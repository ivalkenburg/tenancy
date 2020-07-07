<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Support\Multitenancy\Models\Tenant;
use Faker\Generator as Faker;

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'domain' => $faker->unique()->domainName,
    ];
});
