<?php

use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

    // Mobile specific endpoints
    Route::get('mobile/clients', [ClientController::class, 'mobileIndex'])->name('mobile.clients.index');
    Route::get('mobile/clients/{client}', [ClientController::class, 'mobileShow'])->name('mobile.clients.show');
    Route::post('mobile/clients', [ClientController::class, 'mobileStore'])->name('mobile.clients.store');
    Route::put('mobile/clients/{client}', [ClientController::class, 'mobileUpdate'])->name('mobile.clients.update');
    Route::delete('mobile/clients/{client}', [ClientController::class, 'mobileDestroy'])->name('mobile.clients.destroy');
});
