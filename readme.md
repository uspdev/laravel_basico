# Parte 11 - Autor editando seus próprios posts

## Implementar método update no PostController
- app/Http/Controllers/PostController.php
```php
public function update(Request $request, Post $post)
{
    $post->title        = $request->title;
    $post->content      = $request->content;

    $post->save();
    $request->session()->flash('alert-success', 'Post alterado com sucesso!');
    return redirect("authors/$post->author_id/posts");
}
```

## Alterar a rota para a home do autor
- Adicionar o método login ao AuthorController
```php
/**
 * Redirect logged author to posts
 *
 * @param \App\Author  $author
 * @return \Illuminate\Http\Response
 */
public function login()
{
    $author = \Auth::user()->author;
    $posts = $author->posts;
    return view('authors.posts', compact('posts'));
}
```
- Alterar a rota /home para o autor logado
```php
Route::get('/home', 'AuthorController@login');
```
- Alterar a rota / para a lista de todos os posts (sem login)
```php
Route::get('/', 'PostController@index');
```


