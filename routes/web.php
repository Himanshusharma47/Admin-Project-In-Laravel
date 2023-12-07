<?php

use App\Http\Controllers\CsvToPdfController;
use App\Http\Controllers\InventoryItemsController;
use App\Http\Controllers\ImageZipController;
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

// Display the forms
Route::get('/', [ViewController::class, 'loginForm'])->name('login');

Route::get('/upload-csv', [ViewController::class, 'uploadCsv'])->name('upload.csv');

Route::get('/upload-image', [ViewController::class, 'uploadImage'])->name('upload.image');

Route::get('/change-password', [ViewController::class, 'changePassword'])->name('change.password');


// login form data
Route::post('/login-data', [LoginController::class, 'loginData']);

// Log out the user
Route::get('/logout', [LoginController::class, 'logout']);

// Process the password change form data
Route::post('/password-change-process', [LoginController::class, 'passwordChange']);

// Process the uploaded image data
Route::post('/image-data', [InventoryItemsController::class, 'imageData']);

// Generate pdf
Route::post('/generate-pdf', [CsvToPdfController::class, 'generatePdf']);

// Generate a zip file
Route::post('/generate-zip', [ImageZipController::class, 'generateZip']);

