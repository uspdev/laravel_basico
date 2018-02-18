@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">
                    <h3>Post</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ $action or url('posts') }}">
                        {{csrf_field()}}
                        @isset($post) {{method_field('patch')}} @endisset
                        <input name="author_id" type="hidden" value="{{ encrypt(Auth::User()->author->id) }}">
                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                            <div class="col-md-6">
                                <input id="title" class="form-control" name="title" type="text" value="{{ $post->title or ''}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="content" class="col-md-4 col-form-label text-md-right">Content</label>
                            <div class="col-md-6">
                                <textarea id="content" class="form-control" name="content">{{ $post->content or '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

