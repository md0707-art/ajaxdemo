<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;



// Redirect root URL to customers index
Route::get('/', function () {
    return redirect()->route('customers.index');
});

// Customer Routes
Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/store', [CustomerController::class, 'store'])->name('customers.store'); // ← notice '/store'
    Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
});

