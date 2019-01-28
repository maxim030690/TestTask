<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'salutation' => 'Hello '.$faker->firstName,
        'city' => $faker->city,
        'country' => $faker->country,
        'address' => $faker->address
    ];
});

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'type_id' => rand(1, 2)
    ];
});

$factory->define(App\ProductUser::class, function (Faker $faker) {
    return [
        'product_id' => rand(1, 10000),
        'user_id' => rand(1, 1000)
    ];
});
