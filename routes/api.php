<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\{
    UserController, PlanController, SubscriptionController, AttendanceController, PageController
};

Route::post('/auth/register',[AuthController::class,'register']);

Route::post('/auth/login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum', 'rolecheck:admin'])->prefix('admin')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('plans', PlanController::class);
    Route::apiResource('subscriptions', SubscriptionController::class);
    Route::apiResource('attendances', AttendanceController::class);
    Route::apiResource('pages', PageController::class);
});

Route::middleware(['auth:sanctum', 'rolecheck:trainer'])->prefix('trainer')->group(function () {
    Route::get('members', [UserController::class, 'index']);
    Route::apiResource('attendances', AttendanceController::class)->only(['index','store']);
});

Route::middleware(['auth:sanctum', 'rolecheck:member'])->prefix('member')->group(function () {
    Route::get('my-subscription', [SubscriptionController::class, 'show']);
    Route::get('attendance', [AttendanceController::class, 'index']);
});
