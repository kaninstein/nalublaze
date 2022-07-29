<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlazeController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/check', [BlazeController::class, 'check'])->name('check');
Route::get('/store', [BlazeController::class, 'storeRolls'])->name('store');
Route::get('/calc', [BlazeController::class, 'calc'])->name('calc');
Route::get('/blank/{base}', [BlazeController::class, 'blankAnalisys'])->name('blank_analisys');
Route::get('/roll/{base}', [BlazeController::class, 'rollAnalisys'])->name('roll_analisys');
Route::get('/second/{start}/{end}', [BlazeController::class, 'secondsAnalisys'])->name('second_analisys');
Route::get('/analisys', [BlazeController::class, 'analisys'])->name('analisys');
Route::get('/checksign/{id}/{time}', [BlazeController::class, 'checkSigns'])->name('check_signs');
