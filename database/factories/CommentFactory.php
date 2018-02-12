<?php

use App\Post;
use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'author_email'  => $faker->unique()->safeEmail,
        'content'       => $faker->paragraph(2),

        'post_id' => function () {
            return Post::orderByRaw("RAND()")
                ->take(1)
                ->first()
                ->id;
        }
    ];
});
