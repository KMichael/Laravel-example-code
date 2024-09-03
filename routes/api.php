<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiBookController;
use App\Http\Controllers\Api\ApiAuthorController;
use App\Http\Controllers\Api\ApiGenreController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Без авторизации
Route::get('/books', [ApiBookController::class, 'index']);
Route::get('/books/{id}', [ApiBookController::class, 'show']);
Route::get('/authors', [ApiAuthorController::class, 'index']);
Route::get('/authors/{id}', [ApiAuthorController::class, 'show']);
Route::get('/genres', [ApiGenreController::class, 'index']);

//Авторизация
Route::post('/login', [AuthController::class, 'login']);

//Выход
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Обновление книги
Route::put('/books/{book}', [BookController::class, 'update'])->middleware('auth:sanctum', 'can:update,book');

//Удаление книги
Route::delete('/books/{book}', [BookController::class, 'destroy'])->middleware(['auth:sanctum', 'can:delete,book']);

//Обновление данных пользователя
Route::put('/user', [ApiAuthorController::class, 'update'])->middleware('auth:sanctum');

