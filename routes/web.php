<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});
Route::get('dashboard', [UserController::class, 'dashboard']);
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class,'postUser']) -> name('user.postUser');
Route::get('/login',[UserController::class ,'login'])->name('login');
Route::post('check-login', [UserController::class,'CheckLogin'])->name('user.CheckLogin'); 
Route::get('logOut', [UserController::class, 'logOut'])->name('logOut');
Route::get('/list', [UserController::class, 'listUser']);
Route::get('/show', [UserController::class, 'showUser'])->name('user.show');
Route::get('/create', [UserController::class, 'create'])->name('user.create');
Route::post('create', [UserController::class, 'createUser'])->name('user.createUser');
Route::get('delete', [UserController::class, 'delete'])->name('user.delete');
Route::get('/user/{id}/edit', [UserController::class, 'editUser'])->name('user.editUser');
Route::post('/user/{id}/update', [UserController::class, 'updateUser'])->name('user.updateUser');