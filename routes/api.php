<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Mobile\MobileAuthController;
use Illuminate\Support\Facades\Route;

// Rutas para autenticación móvil
Route::prefix('mobile')->group(function () {
    Route::post('/login', [MobileAuthController::class, 'login']);
    Route::post('/logout', [MobileAuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/refresh', [MobileAuthController::class, 'refresh'])->middleware('auth:sanctum');
});

// Rutas solo para superadmin
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('roles', [RoleController::class, 'store'])
        ->middleware('can:create,App\Models\Role');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])
        ->middleware('can:assignRoles,App\Models\Role');
    Route::put('roles/{role}', [RoleController::class, 'update'])
        ->middleware('can:assignRoles,App\Models\Role');

    Route::post('permissions', [PermissionController::class, 'store'])
        ->middleware('can:create,App\Models\Role');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])
        ->middleware('can:assignRoles,App\Models\Role');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])
        ->middleware('can:assignRoles,App\Models\Role');
});

// Rutas para admin y superadmin
Route::middleware(['auth:sanctum'])->group(function () {
    // Ruta para actualizar permisos de un rol
    Route::put('roles-permissions/{role}', [RolePermissionController::class, 'update'])
        ->middleware('can:assignRoles,App\Models\Role');
});
