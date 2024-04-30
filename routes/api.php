<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoriesController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => '/v1'], function(){

    Route::get('/welcome', function () {
        return view('welcome');
    });

Route::get('/products', ApiProductsController::class . '@index')->name('index.products');
Route::post('/products', ApiProductsController::class . '@store')->name('store.products');
Route::get('/products/{id}', ApiProductsController::class . '@show')->name('show.products');
Route::put('/products/{id}/edit', ApiProductsController::class . '@update')->name('update.products');
Route::delete('/products/{id}/edit', ApiProductsController::class . '@destroy')->name('destroy.products');

Route::get('/categories', CategoriesController::class . '@index')->name('index.categories');
Route::post('/categories', CategoriesController::class . '@store')->name('store.categories');
Route::get('/categories/{id}', CategoriesController::class . '@show')->name('show.categories');
Route::put('/categories/{id}/edit', CategoriesController::class . '@update')->name('update.categories');
Route::delete('/categories/{id}/edit', CategoriesController::class . '@destroy')->name('destroy.categories');


Route::get('/users', UsersController::class . '@index')->name('index.users');
Route::post('/users', UsersController::class . '@store')->name('store.users');
Route::get('/users/{id}', UsersController::class . '@show')->name('show.users');
Route::put('/users/{id}/edit', UsersController::class . '@update')->name('update.users');
Route::delete('/users/{id}/edit', UsersController::class . '@destroy')->name('destroy.users');

Route::post('/login', CategoriesController::class . '@store')->name('store.categories');
Route::post('/register', CategoriesController::class . '@store')->name('store.categories');

});