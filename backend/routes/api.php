<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum', 'is_active']], function () {
    
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Users
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::post('/users', 'store');
        Route::put('/users/{user}', 'update');
        Route::delete('/users/{user}', 'destroy');
        Route::get('users/relatedLists', 'relatedLists');


    });

    // Permissions
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/permissions', 'index');
        Route::post('/permissions', 'store');
        Route::put('/permissions/{permission}', 'update');
        Route::delete('/permissions/{permission}', 'destroy');
    });

    // Roles
    Route::controller(RoleController::class)->group(function () {
        Route::get('/roles', 'index');
        Route::post('/roles', 'store');
        Route::put('/roles/{role}', 'update');
        Route::delete('/roles/{role}', 'destroy');
        Route::get('roles/relatedLists', 'relatedLists');
    });
});
