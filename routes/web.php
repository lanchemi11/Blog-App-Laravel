<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::group(['prefix' => '/posts'], static function () {
//     Route::get('/', 'PostController@index')->middleware('auth')->name('posts.index');
//     // Route::get('/create', 'PostController@create')->middleware('auth')->name('posts.create');
//     // Route::post('/create', 'PostController@store')->middleware('auth')->name('posts.store');
//     // Route::get('/edit', 'PostController@edit')->middleware('auth')->name('posts.edit');
//     // Route::put('/update', 'PostController@update')->middleware('auth')->name('posts.update');
//     // Route::delete('/', 'PostController@destroy')->middleware('auth')->name('posts.destroy');
// });
// Route::group(['prefix' => '/posts'], static function () {
//     // Route::resource('/', PostController::class)->name('posts.index');
//     Route::get('/', 'PostController@index')->name('posts.index');
//     Route::get('/create', 'PostController@create')->name('posts.create');
// });

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
});

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');


Route::post('/posts/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.delete');

require __DIR__.'/auth.php';
