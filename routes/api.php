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
Route::post('publisher', 'Api\PublishersController@create');

// BOOKS
Route::get('book/{books?}', 'Api\BooksController@get');
Route::post('book', 'Api\BooksController@create');
Route::put('book/{books}', 'Api\BooksController@update');
Route::delete('book/{books}', 'Api\BooksController@delete');
