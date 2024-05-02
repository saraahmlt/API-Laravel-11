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


    

Route::get('/products', ApiProductsController::class . '@index')->middleware('auth:sanctum')->name('index.products');
Route::post('/products', ApiProductsController::class . '@store')->middleware('auth:sanctum')->name('store.products');
Route::get('/products/{id}', ApiProductsController::class . '@show')->middleware('auth:sanctum')->name('show.products');
Route::put('/products/{id}/edit', ApiProductsController::class . '@update')->middleware('auth:sanctum')->name('update.products');
Route::delete('/products/{id}/edit', ApiProductsController::class . '@destroy')->middleware('auth:sanctum')->name('destroy.products');

Route::get('/categories', CategoriesController::class . '@index')->middleware('auth:sanctum')->name('index.categories');
Route::post('/categories', CategoriesController::class . '@store')->middleware('auth:sanctum')->name('store.categories');
Route::get('/categories/{id}', CategoriesController::class . '@show')->middleware('auth:sanctum')->name('show.categories');
Route::put('/categories/{id}/edit', CategoriesController::class . '@update')->middleware('auth:sanctum')->name('update.categories');
Route::delete('/categories/{id}/edit', CategoriesController::class . '@destroy')->middleware('auth:sanctum')->name('destroy.categories');


Route::get('/users', UsersController::class . '@index')->middleware('auth:sanctum')->name('index.users');
Route::post('/users', UsersController::class . '@store')->middleware('auth:sanctum')->name('store.users');
Route::get('/users/{id}', UsersController::class . '@show')->middleware('auth:sanctum')->name('show.users');
Route::put('/users/{id}/edit', UsersController::class . '@update')->middleware('auth:sanctum')->name('update.users');
Route::delete('/users/{id}/edit', UsersController::class . '@destroy')->middleware('auth:sanctum')->name('destroy.users');

Route::post('/login', [UsersController::class, 'login'])->name('users.login');
Route::post('/register', [UsersController::class, 'register'])->name('users.register');


});