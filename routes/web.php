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
Route::get('/',['uses'=>'IndexController@index','as'=>'home']);
Route::get('/list/{text?}/{city?}/{user?}',['uses'=>'IndexController@index','as'=>'searchList']); 

Route::get('/messages/add',['uses'=>'IndexController@create','as'=>'article-add']);
Route::post('/messages/store',['uses'=>'IndexController@store','as'=>'article-store']);
Route::get('/messages/{article}',['uses'=>'IndexController@show','as'=>'article-show']);
Route::get('/messages/edit/{article}',['uses'=>'IndexController@edit','as'=>'article-edit']);
Route::post('/messages/edit/{article}',['uses'=>'IndexController@update','as'=>'article-update']);
Route::get('/messages/delete/{article}',['uses'=>'IndexController@destroy','as'=>'article-delete']);

Route::post('/comment',['uses'=>'CommentController@store','as'=>'comment-store']);
Route::post('/comment/edit/{comment}',['uses'=>'CommentController@update','as'=>'comment-update']);
Route::get('/comment/delete/{comment}',['uses'=>'CommentController@destroy','as'=>'comment-delete']);

Route::post('/search',['uses'=>'SearchController@index','as'=>'search']);

Route::get('/profile/{id?}',['uses'=>'ProfileController@show','as'=>'profile']);
Route::get('/users',['uses'=>'ProfileController@index','as'=>'users']);
Route::get('/users/create',['uses'=>'ProfileController@create','as'=>'user-add']);
Route::post('/users/add',['uses'=>'ProfileController@store','as'=>'users_store']);
Route::get('/users/edit/{user}',['uses'=>'ProfileController@edit','as'=>'users_edit']);
Route::post('/users/edit/{user}',['uses'=>'ProfileController@update','as'=>'users_update']);
Route::get('/users/delete/{user}',['uses'=>'ProfileController@delete','as'=>'users_delete']);


Auth::routes();

