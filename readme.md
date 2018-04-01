# Parte 9 - Views - Listando posts do autor logado

## Alterar os seeders do banco de dados
- database/seeds/DatabaseSeeder.php
```php
<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "Creating 10 users...\n";
        factory(App\User::class, 10)->create();
        echo "Creating 10 authors...\n";
        factory(App\Author::class, 10)->create();
        echo "Creating 36 posts related to random authors...\n";
        factory(App\Post::class, 36)->create();
        echo "Creating 67 comments related to random posts...\n";
        factory(App\Comment::class, 67)->create();
    }
}
```
- database/factories/AuthorFactory.php
```php
<?php

use Faker\Generator as Faker;

$factory->define(App\Author::class, function (Faker $faker) {
    return [
        'bio'   => $faker->paragraph(1),
        'user_id' => $faker->unique()->numberBetween(1, 10)
    ];
});
```

## "Zerar"o banco de dados e popular com o novo seeder
```php
php artisan migrate:fresh
php artisan db:seed
```

## Criar a rota para a view dos posts do autor
- routes/web.php
```php
Route::get('authors/{author}/posts', 'AuthorController@posts');
```

## Criar o método que lista os posts do autor
- Adicionar método em app/Http/Controllers/AuthorController.php
```php
public function posts(Author $author)
{
    $posts = $author->posts;
    return view('authors.posts', compact('posts'));
}
```

## Criar a view que lista os posts do autor
- Criar arquivo resources/views/authors/posts.blade.php
```php
@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Meus Posts</h2>
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="fechar">&times;</a></p>
                    @endif
                @endforeach
            </div>
            @foreach ($posts as $post)
                <div class="card card-default">
                    <div class="card-header">
                        <h3>{{ $post->title }} :: <small>por {{ $post->author->user->name }}</small></h3>
                    </div>
                    <div class="card-body">
                        <p>
                            {{ $post->content }} <br>
                            <a class="btn btn-danger" href="{{ action('PostController@destroy', $post->id) }}" title="Apagar o post">Apagar</a><br>
                            <a class="btn btn-primary" href="{{ action('PostController@edit', $post->id) }}" title="Editar o post">Editar</a><br>
                        </p>
                    </div>
                </div>
                <br>
            @endforeach
        </div>
    </div>
@endsection
