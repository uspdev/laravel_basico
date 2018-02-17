# Parte 4 - AuthorController

## Criar o controller para os autores
- php artisan make:controller AuthorController --resource
    - Cria o controller app/Http/Controllers/AuthorController.php com os métodos (actions)

## Criar a rota para o nosso resource Author
- routes/web.php
    ```php
    Route::resource('authors', 'AuthorController');
    ```

## Mostrando todos os autores
- app/Http/Controllers/AuthorController.php
    - No navegador:
        - http://localhost:8000/authors
    - Método index
    ```php
    public function index()
    {
        //$authors = json_encode(Author::all(), JSON_PRETTY_PRINT);
        $authors = Author::join('posts', 'posts.author_id', '=', 'authors.id')
            ->groupBy('authors.id')
            ->get([
                'authors.id',
                'authors.name',
                'authors.email',
                DB::raw('count(posts.id) as posts')
            ]
        );

        $authors = json_encode($authors, JSON_PRETTY_PRINT);

        return "<pre>$authors</pre>";
    }
    ```

## Mostrando apenas um autor
- app/Http/Controllers/AuthorController.php
    - No navegador:
        - http://localhost:8000/authors/{id} ({id} = número do ID do author)
    - Método show($author)
    ```php
    public function show(Author $author)
    {
        $posts = $author->posts->count();

        $text = <<<TEXT
        ID:     $author->id
        Name:   $author->name
        E-mail: $author->email
        Bio:    $author->bio
        Posts:  $posts
TEXT;
        /* A marca de fim do heredoc (TEXT;)
           deve ficar na coluna zero da linha */

        return "<pre>$text</pre>";
    }
    ```

## Criar, editar e deletar autores
Esses métodos serão implementados nas próximas partes, quando tivermos nossas páginas com os formulários.
- Acessando a action edit de um autor
    - app/Http/Controllers/AuthorController.php
        - No navegador:
            - https://localhost:8000/authors/{id}/edit ({id} = número do ID do author)
        - Método edit
        ```php
        public function edit(Author $author)
        {
            /**
             * Nossa página (view) edit terá
             * o formulário para editar o
             * autor
             */

            return "Ainda não podemos editar o autor <strong>$author->name</strong> porque não temos o formulário.";
        }
        ```

## Links de referência
- [Laravel 5.6 - Resource Controllers](https://laravel.com/docs/5.6/controllers#resource-controllers)
