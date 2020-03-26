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

//Route::get('/', function () {
//    return view('home');
//})->name('home');

Route::get('/', 'HomeController@home')
        ->name('home');
        //->middleware('auth');

Route::get('/contact', 'HomeController@contact')->name('contact');

Route::get('/secret', 'HomeController@secret')
        ->name('secret')
        ->middleware('can:home.secret');

//Route::get('/contact', function () {
//    return view('contact');
//});

// Route::view('/contact', 'contact')->name('contact');

//Route::get('/blog-post/{blog_id}/{author}', function($id, $author) {
//    return $id . $author;
//});

//Route::get('/blog-post/{id}/{welcome?}', 'HomeController@blogPost')->name('blog-post');

// Route::resource('/posts', 'PostController');

// Route::resource('/posts', 'PostController')->only(['index', 'show', 'create', 'store', 'edit', 'update']); // == 

// Route::resource('/posts', 'PostController')->except(['destroy']);

Route::resource('/posts', 'PostController');
Route::get('/posts/tag/{tag}', 'PostTagController@index')->name('posts.tags.index');

Route::resource('posts.comments', 'PostCommentController')->only(['store']);
Route::resource('users.comments', 'UserCommentController')->only(['store']);
Route::resource('users', 'UserController')->only(['show', 'edit', 'update']);

Route::get('mailable', function() {
    $comment = App\Comment::find(1);
    return new App\Mail\CommentPostedMarkdown($comment);
});

Auth::routes();


