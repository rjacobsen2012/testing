<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Car;
use Faker\Generator as Faker;

$factory->define(Car::class, function (Faker $faker) {
    return [
        'model' => $faker->name,
        'make' => $faker->name,
        'year' => $faker->year
    ];
});
