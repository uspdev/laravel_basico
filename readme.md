# Parte 9 - Views - Listando posts do autor logado

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
