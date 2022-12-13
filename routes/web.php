<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Accesvalide;
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/', [HomeController::class, 'home']);

Route::get('/admin', [AdminController::class, 'home']);

Route::get('/demande', [HomeController::class, 'demande'])->name('demande');

Route::post('/envoidemande', [HomeController::class, 'envoi'])->name('envoidemande');

Route::get('/status', [HomeController::class, 'status'])->name('status');

Route::get('/details', [AdminController::class, 'details'])->name('details');

Route::get('/update/{id}', [AdminController::class, 'update'])->name('update');

Route::post('/modifier/{id}', [AdminController::class, 'modifier'])->name('modifier');
