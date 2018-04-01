<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resources([
    'authors' => 'AuthorController',
    'posts' => 'PostController'
]);
Route::delete('comments/{comment}', 'CommentController@destroy');
Route::get('authors/{author}/posts', 'AuthorController@posts');

Auth::routes();

Route::get('/home', 'AuthorController@login');
Route::get('/', 'PostController@index');
