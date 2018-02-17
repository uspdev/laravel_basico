# Parte 7 - Views - Posts

## Listando todos os posts
- app/Controllers/PostController.php
```php
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }
```
- resources/views/posts/index.blade.php
```php
    @extends('layouts.app')
    @section('content')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    @foreach ($posts as $post)
                        <div class="card-header">
                            <h3>{{ $post->title }} :: por {{ $post->author->user->name }}</h3>
                        </div>
                        <div class="card-body">
                            <p>
                                {{ substr($post->content, 1, 60) }}...
                                <a href="{{ action('PostController@show', $post->id) }}" title="Ler o post">Ler o post</a>
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection
```
- Acesse, no navegador: http://localhost:8000/posts

## Mostrando o post
- app/Http/Controllers/PostController.php
```php
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
```
- resources/views/posts/show.blade.php
```php
@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <h3>{{ $post->title }} :: por {{ $post->author->user->name }}</h3>
                </div>
                <div class="card-body">
                    <p>
                        {{ $post->content }}
                    </p>
                    <h4>Comentários:</h4>
                    <!-- Comentários do post -->
                    @foreach($post->comments as $comment)
                        <div class="card card-default">
                            <div class="card-header">
                                {{ $comment->author_email }}
                            </div>
                            <div class="card-body">
                                {{ $comment->content }}
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
```

## Links para saber mais
- [Laravel 5.6 - Views](https://laravel.com/docs/5.6/views)
- [Laravel 5.6 - Template](https://laravel.com/docs/5.6/blade)

