<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas solo para superadmin
Route::middleware(['auth:sanctum'])->group(function () {
    // POST routes
    Route::post('roles', [RoleController::class, 'store'])
        ->middleware('can:create,App\Models\Role')
        ->name('roles.store')
        ->view('roles.create');
        
    Route::post('permissions', [PermissionController::class, 'store'])
        ->middleware('can:create,App\Models\Role')
        ->name('permissions.store')
        ->view('permissions.create');
});

// Rutas para admin y superadmin
Route::middleware(['auth:sanctum'])->group(function () {
    // GET routes
    Route::get('roles', [RoleController::class, 'index'])
        ->middleware('can:assignRoles,App\Models\Role')
        ->name('roles.index')
        ->view('roles.index');
    
    // PUT routes    
    Route::put('roles/{role}', [RoleController::class, 'update'])
        ->middleware('can:assignRoles,App\Models\Role')
        ->name('roles.update')
        ->view('roles.edit');
});