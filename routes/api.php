<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// PUBLISHERS
Route::post('publisher', 'PublishersController@create');

// BOOKS
Route::get('book/{books?}', 'BooksController@get');
Route::post('book', 'BooksController@create');
Route::put('book/{books}', 'BooksController@update');
Route::delete('book/{books}', 'BooksController@delete');
