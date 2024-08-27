<?php
use App\Http\Controllers\PermissionController;

Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index') ;
Route::post('/permissions/{id?}', [PermissionController::class, 'store']);
Route::get('/permissions/all', [PermissionController::class, 'getPermissions']);
Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);
