<?php

use App\Author;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title'     => $faker->sentence(4),
        'content'   => $faker->paragraph(4),
        
        'author_id' => function () {
            return Author::orderByRaw("RAND()")
                ->take(1)
                ->first()
                ->id;
        }
    ];
});
