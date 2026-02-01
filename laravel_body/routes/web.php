<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\VisitController;

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

// Custom root
Route::match('get', '/', [SeatController::class, 'index'])->name('index');
Route::match('post', '/', [SeatController::class, 'show'])->name('show');
Route::post('/confirm', [SeatController::class, 'confirm'])->name('confirm');
Route::patch('/confirmed', [SeatController::class, 'confirmed'])->name('confirmed');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
	return Inertia::render('Dashboard');
})->name('dashboard');
