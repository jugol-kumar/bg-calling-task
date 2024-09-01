<?php

use App\Http\Controllers\Api\V1\AuthorizationController;
use App\Http\Controllers\Api\V1\BusinessSettingController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Auth\Admin\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// admin panel Auth routes
Route::prefix('v1')->middleware(['auth:sanctum'])->group( function () {

    Route::withoutMiddleware(['auth:sanctum'])->group(function (){
        // Admin Guest Route
        Route::post('/login', [LoginController::class, 'login']);
    });

    // role and permission routes
    Route::get('/permissions-for-create-roles', [AuthorizationController::class, 'index']);
    Route::post('/create-role', [AuthorizationController::class, 'store']);
    Route::get('/get-all-roles', [AuthorizationController::class, 'getAllRoles']);
    Route::get('/get-role-with-permissions/{id}', [AuthorizationController::class, 'editRole']);
    Route::post('/update-role/{id}', [AuthorizationController::class, 'updateRole']);

    // complete crud module all resource routes
    Route::apiResources([
       'role' => RoleController::class,
       'user' => UserController::class
    ]);



    Route::get('/get-settings', [BusinessSettingController::class, 'getAllSettings']);

    Route::put('/profile-update', [LoginController::class, 'updateProfile']);
    Route::post('/password-update', [LoginController::class, 'updatePassword']);

    Route::any('/logout', [LoginController::class, 'logout']);
});


Route::get("/storage", function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return "storage linked";
});