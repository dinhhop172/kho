<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();


    Route::group(['prefix' => 'users', 'middleware' => 'auth'], function () {
        Route::get('', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/show/{id}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');
        Route::get('create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('store', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/{id}/update', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::get('/{id}/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/search', [App\Http\Controllers\UserController::class, 'search'])->name('users.search');




    });
    Route::group(['prefix' => 'roles', 'middleware' => 'auth'], function () {
        Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        Route::get('/show/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('roles.show');
        Route::get('create', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
        Route::post('store', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
        Route::get('/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
        Route::post('/{id}/update', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
        Route::get('/{id}/delete', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/search', [App\Http\Controllers\RoleController::class, 'search'])->name('roles.search');
    });


// Route::get('asd', [RoleController::class], 'index')->name('roles.index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
?>
