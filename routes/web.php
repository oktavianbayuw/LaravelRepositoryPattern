<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [ProductController::class, 'index']);
Route::get('/product/create', [ProductController::class, 'store']);
Route::get('/product/update/{id}', [ProductController::class, 'update']);
Route::get('/product/{id}', [ProductController::class, 'show']);
// Route::get('/product/category', [CategoryProductController::class, 'index']);
Route::post('/product/delete/{id}', [CategoryProductController::class, 'delete']);
