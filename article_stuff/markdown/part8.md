# Parte 8 - Views - Criando Posts

## Logar o usuário
O user (que também é um author) só poderá criar e editar posts se estiver logado.

### Ajustar o PostController para autenticar o usuário
- Criar método __construct em app/Http/Controllers/PostController.php
```php
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
```

## Criando o formulário
- resources/views/forms/post.blade.php
```php
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
```

- resources/views/posts/create.blade.php
```php
@include('forms.post')
```

- resources/views/posts/edit.blade.php
```php
@include('forms.post')
```

## Ajustando o app/Http/Controllers/PostController.php
Ajustar o controller para efetuar as operações corretamente
- Método index
```php
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index', compact('posts'));
    }
```
- Método create
```php
    public function create()
    {
        return view('posts.create');
    }
```
- Método store
```php
    public function store(Request $request)
    {
        $post = new Post;

        $post->title        = $request->title;
        $post->content      = $request->content;
        $post->author_id    = decrypt($request->author_id);

        $post->save();
        $request->session()->flash('alert-success', 'Post criado com sucesso!');
        return redirect()->route('posts.index');
    }
```
- Método edit
```php
    public function edit(Post $post)
    {
        $action = action('PostController@update', $post->id);

        return view('posts.edit', compact('post', "action"));
    }
```

## View para edição do Post
- resources/views/posts/edit.blade.php
```php
@include('forms.post')
```

## Links para saber mais
[Laravel 5.6 - Blade (Estruturas de Controle)](https://laravel.com/docs/5.6/blade#control-structures)
[Laravel 5.6 - Authentication](https://laravel.com/docs/5.6/authentication)
