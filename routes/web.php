<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcessLoansController;

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

Route::get('/create', [\App\Http\Controllers\Controller::class, 'create'])->name('loan.create');

Route::post('/store', ProcessLoansController::class)->name('loan.store');
Route::get('/loans', [ProcessLoansController::class, 'showLoans'])->name('loan.list');
Route::get('/loan/{loan}', [ProcessLoansController::class, 'details'])->name('loan.show');
Route::post('/add-extra-payment', [ProcessLoansController::class, 'addExtraPayment'])->name('loan.addExtraPayment');

