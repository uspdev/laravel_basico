# Parte 5 - PostController

## Criar o controller para os posts
- php artisan make:controller PostController --resource
    - Cria o controller app/Http/Controllers/PostController.php com os métodos (actions)

## Criar a rota para o nosso resource Post
- routes/web.php
    ```php
    Route::resources([
        'authors' => 'AuthorController',
        'posts' => 'PostController'
    ]);
    ```

## Mostrando todos os posts
- app/Http/Controllers/PostController.php
    - No navegador:
        - http://localhost:8000/posts
    - Método index
    ```php
    public function index()
    {
        $posts = json_encode(Post::all(), JSON_PRETTY_PRINT);
        return "<pre>$posts</pre>";
    }
    ```

## Mostrando apenas um post
- app/Http/Controllers/PostController.php
    - No navegador:
        - http://localhost:8000/posts/{id} ({id} = número do ID do post)
    - Método show($post)
    ```php
    public function show(Post $post)
    {
        $author = $post->author->name;

        $text = <<<TEXT
        ID:         $post->id
        Title:      $post->title
        Content:    $post->content
        Author:     $author
    ```
```php
TEXT;
        // A marca do fim do heredoc (TEXT;) deve ficar na coluna zero da linha.
        // ou teremos um erro - Unexpected end of file
```
    ```php
    return "<pre>$text</pre>";
    }
    ```

## Criar, editar e deletar posts
Esses métodos serão implementados nas próximas partes, quando tivermos nossas páginas com os formulários.
- Acessando a action edit de um post
    - app/Http/Controllers/PostController.php
        - No navegador:
            - https://localhost:8000/posts/{id}/edit ({id} = número do ID do post)
        - Método edit
        ```php
        public function edit(Post $post)
        {
            /**
             * Nossa página (view) edit terá
             * o formulário para editar o
             * post
             */

            return "Ainda não podemos editar o post <br><strong>$post->title</strong><br> porque não temos o formulário.";
        }
        ```

## Links para saber mais (vá fundo)
- [Laravel 5.6 - Resource Controllers](https://laravel.com/docs/5.6/controllers#resource-controllers)
- [PHP - Strings - Referência para o uso de heredoc](https://secure.php.net/manual/pt_BR/language.types.string.php)
