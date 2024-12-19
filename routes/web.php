<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/admin/login', 'Admin\UserController@login');
Route::post('/admin/check', 'Admin\UserController@check');
Route::get('/admin/logout', 'Admin\UserController@logout');

Route::get('/admin/index', 'Admin\IndexController@index')->middleware('Admin');
Route::prefix('category')->namespace('Admin')->middleware(['Admin'])->group(function () {
    Route::get('add', 'CategoryController@add');
    Route::get('', 'CategoryController@index');
    Route::post('save', 'CategoryController@save');
    Route::post('sort', 'CategoryController@sort');
    Route::get('edit/{id}', 'CategoryController@edit');
    Route::any('delete/{id}', 'CategoryController@delete');
});
// Route::post('/category/save', 'Admin\CategoryController@save');
// Route::post('/category/sort', 'Admin\CategoryController@sort');
// Route::get('category/edit/{id}', 'Admin\CategoryController@edit');
// Route::post('/category/delete/{id}', 'Admin\CategoryController@delete');

Route::prefix('content')->namespace('Admin')->middleware(['Admin'])
    ->group(function () {
        Route::get('add', 'ContentController@add');
        Route::get('edit/{id}', 'ContentController@edit');
        Route::get('{id?}', 'ContentController@index')->name('content');
        Route::post('save', 'ContentController@save');
        Route::post('upload', 'ContentController@upload');
        Route::post('delete/{id}', 'ContentController@delete')->name('content.delete');
    });

Route::prefix('adv')->namespace('Admin')->middleware(['Admin'])
    ->group(function () {
        Route::get('add', 'AdvController@add');
        Route::post('save', 'AdvController@save');
        Route::get('', 'AdvController@index');
        Route::post('delete/{id}', 'AdvController@delete');
    });

Route::prefix('advcontent')->namespace('Admin')->middleware(['Admin'])
    ->group(function () {
        Route::get('add/{id?}', 'AdvcontentController@add')->name('advcontent.add');
        Route::post('save', 'AdvcontentController@save');
        Route::post('upload', 'AdvcontentController@upload');
        Route::get('', 'AdvcontentController@index');
        Route::post('delete/{id}', 'AdvcontentController@delete');
    });

Route::get('/','IndexController@index');
Route::post('/register','UserController@register');
Route::post('/login','UserController@login');
Route::get('/logout','UserController@logout');
Route::get('/lists/{id}','IndexController@lists');
Route::name('home')->get('/','IndexController@index');

Route::name('category')->get('/lists/{id}','IndexController@lists');
Route::get('/detail/{id}','IndexController@detail');
Route::name('detail')->get('/detail/{id}','IndexController@detail');
Route::get('/like/{id}','IndexController@like');
Route::get('/like/{id}','IndexController@like');
Route::get('/comment','IndexController@comment');