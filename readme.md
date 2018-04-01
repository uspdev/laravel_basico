# Parte 12 - Autor deletando comentários em seus posts

## Implementar método destroy no CommentController
- app/Http/Controllers/CommentController.php
```php
public function destroy(Request $request, Comment $comment)
{
    $comment->delete();
    $request->session()->flash('alert-success', 'Comentário apagado com sucesso!');
    return redirect()->back();
}
```

## Adicionar a rota para o método destroy do CommentController
- routes/web.php
```php
Route::delete('comments/{comment}', 'CommentController@destroy');
```

## Adicionar link para mostrar o post e seus comentários na view de posts do autor
- resources/views/authors/posts.blade.php
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
                            <a href="{{ action('PostController@show', $post->id) }}" title="Ver post e comentários">Ver post e comentários</a><br>
                            <a class="btn btn-primary" href="{{ action('PostController@edit', $post->id) }}" title="Editar o post">Editar</a><br>
                            <form method="post" action="{{ action('PostController@destroy', $post->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="submit" class="btn btn-danger delete-button" onclick="return confirm('Tem certeza?');")>Apagar</button>
                            </form>
                        </p>
                    </div>
                </div>
                <br>
            @endforeach
        </div>
    </div>
@endsection
```

## Alterar a view show do post para mostrar o botão de deletar somente para o autor do post
```php
@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <h3>{{ $post->title }} :: <small>por {{ $post->author->user->name }}</small></h3>
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
                                @if (Auth::check() && Auth::user()->author->id == $post->author_id)
                                    <form method="post" action="{{ action('CommentController@destroy', $comment->id) }}">
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}
                                        <button type="submit" class="btn btn-danger delete-button" onclick="return confirm('Tem certeza?');")>Apagar Comentário</button>
                                    </form>
                                @endif
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
[Laravel 5.6 - Blade] (https://laravel.com/docs/5.6/blade)
[Laravel 5.6 - Authentication] (https://laravel.com/docs/5.6/authentication)
