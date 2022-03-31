<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Car;
use App\Models\Trip;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Trip::class, function (Faker $faker) {
    return [
        'date' => Carbon::now(),
        'miles' => $faker->randomFloat(1, 0, 20),
        'car_id' => factory(Car::class),
    ];
});
