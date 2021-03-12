<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionsController;
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

Route::get('/dashboard', [DashboardController::class,"listing"])->middleware(['auth'])->name('dashboard');
Route::post('/dashboard/addTenant', [DashboardController::class,"addTenant"])->middleware(['auth'])->name('addTenant');
Route::get('/transactions',[TransactionsController::class,"listing"])->middleware(['auth'])->name('transactions');
Route::get('/transactions/add',[TransactionsController::class,"newTransaction"])->middleware(['auth'])->name('addTransactions');
Route::post('/transactions/add',[TransactionsController::class,'postTransaction'])->middleware(['auth'])->name('storeTransaction');
Route::get("/transactions/calculate", [TransactionsController::class, "calculate"])->middleware(["auth"])->name('calculateTransaction');
Route::get('/dashboard/tenant/{tenantId}', [DashboardController::class, 'getTenantInfo'])->middleware(["auth"])->name('viewTenant');
require __DIR__.'/auth.php';
