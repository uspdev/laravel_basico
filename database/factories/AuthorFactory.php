<?php

use Faker\Generator as Faker;

$factory->define(App\Author::class, function (Faker $faker) {
    return [
        'bio'   => $faker->paragraph(1),
        'user_id' => $faker->unique()->numberBetween(1, 10)
    ];
});
