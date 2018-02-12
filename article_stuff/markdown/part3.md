# Passos para a parte 3 do artigo

## Criar as factories
    - php artisan make:factory AuthorFactory --model="App\\Author"
    - php artisan make:factory PostFactory --model="App\\Post"
    - php artisan make:factory CommentFactory --model="App\\Comment"

## Código das factories
    - AuthorFactory
        ```php
        <?php

        use Faker\Generator as Faker;

        $factory->define(App\Author::class, function (Faker $faker) {
            return [
                'name'  => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'bio'   => $faker->paragraph(1),
            ];
        });
        ```
    - PostFactory
        ```php
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
        ```
    - CommentFactory
        ```php
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
        ```
