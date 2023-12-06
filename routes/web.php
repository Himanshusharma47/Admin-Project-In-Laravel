<?php

use App\Http\Controllers\InventoryItemsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ViewController;
use App\Models\Login;
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


Route::get('/', [ViewController::class, 'loginForm']);
Route::get('/upload-csv', [ViewController::class, 'uploadCsv'])->name('upload.csv');
Route::get('/upload-image', [ViewController::class, 'uploadImage'])->name('upload.image');
Route::get('/change-password', [ViewController::class, 'changePassword'])->name('change.password');



Route::post('/login-data', [LoginController::class, 'loginData']);
Route::post('/password-change-process', [LoginController::class, 'passwordChange']);

Route::post('/image-data', [InventoryItemsController::class, 'imageData']);





