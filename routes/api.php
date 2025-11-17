<?php

use App\Http\Controllers\Api\ListController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\RiskController;
use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;

// API routes that require authentication
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/modules', [ModuleController::class, 'index'])->name('api.modules.index');
    Route::get('/modules/{module:slug}', \App\Http\Controllers\Api\ModuleDetailController::class)->name('api.modules.show');
    Route::get('/risks', [RiskController::class, 'index'])->name('api.risks.index');
    Route::get('/lists', [ListController::class, 'index'])->name('api.lists');
    Route::get('/dashboard', DashboardController::class)->name('api.dashboard');
    Route::get('/compliance', \App\Http\Controllers\Api\ComplianceController::class)->name('api.compliance');
});


