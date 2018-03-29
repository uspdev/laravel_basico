<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
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

    /**
     * List all posts from the logged author
     *
     * @param \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function posts(Author $author)
    {
        $posts = $author->posts;
        return view('authors.posts', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /**
         * Nossa página (view) create terá
         * o formulário para cadastrar um
         * autor
         */
        return "Na próxima parte teremos o formulário de cadastro do autor aqui.";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * É para cá que os dados do formulário
         * virão quando clicarmos no botão
         * para cadastrar um autor
         */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
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
        return "<pre>$text</pre>";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        /**
         * Nossa página (view) edit terá
         * o formulário para editar o
         * autor
         */

        return "Ainda não podemos editar o autor <strong>$author->name</strong> porque não temos o formulário.";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        /**
         * É para cá que os dados do formulário
         * virão quando clicarmos no botão
         * para editar o autor
         */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        /**
         * Ainda não vamos apagar o
         * autor do banco de dados
         * mas logo teremos a view
         * para isso
         */
    }
}
