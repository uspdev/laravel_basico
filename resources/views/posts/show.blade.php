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
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
