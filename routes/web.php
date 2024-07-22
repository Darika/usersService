<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('users')
    ->middleware('auth:web')
    ->controller(\App\Http\Controllers\UsersController::class)->group( function () {
        Route::get('/', 'index')->name('users.index');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/edit/{user}', 'edit')->name('users.edit');
        Route::put('/update', 'update')->name('users.update');
        Route::get('/switchBlock/{user}', 'switchBlock')->name('users.switchBlock');
        Route::delete('/destroy/{user}', 'destroy')->name('users.destroy');
        Route::get('/show/{id}', 'detail');
});
