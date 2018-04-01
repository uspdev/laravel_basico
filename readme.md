# Parte 10 - Autor apagando seus próprios posts

## Implementar método destroy no PostController
- app/Http/Controllers/PostController.php
```php
public function destroy(Request $request, Post $post)
{
    $post->delete();
    $request->session()->flash('alert-success', 'Post apagado com sucesso!');
    return redirect()->back();
}
```

## Alterar a view dos posts do autor
- resources/views/authors/posts
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
                            @if (Auth::check() && Auth::user()->author->id == $post->author_id)
                            <a class="btn btn-primary" href="{{ action('PostController@edit', $post->id) }}" title="Editar o post">Editar</a><br>
                            <form method="post" action="{{ action('PostController@destroy', $post->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="submit" class="btn btn-danger delete-button" onclick="return confirm('Tem certeza?');")>Apagar</button>
                            </form>
                            @endif
                        </p>
                    </div>
                </div>
                <br>
            @endforeach
        </div>
    </div>
@endsection
```

## Ajustar a migration para que possamos apagar o post e seus comentários
Temos que incluir o "onDelete('cascade')", para que os comentários sejam apagados junto com o post.
- database/migrations/*****create_comments.php
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('author_email');
            $table->text('content');
            $table->integer('post_id')->unsigned();
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
```
