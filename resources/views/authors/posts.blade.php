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
