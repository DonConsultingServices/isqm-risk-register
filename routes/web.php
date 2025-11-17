<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IsqmEntryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MonitoringActivityController;
use App\Http\Controllers\DeficiencyTypeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Static Pages
Route::get('/about', [\App\Http\Controllers\PageController::class, 'about'])->name('pages.about');
Route::get('/features', [\App\Http\Controllers\PageController::class, 'features'])->name('pages.features');

// User Guide
Route::prefix('user-guide')->name('user-guide.')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\UserGuideController::class, 'index'])->name('index');
    Route::get('/{topic}', [\App\Http\Controllers\UserGuideController::class, 'show'])->name('show');
});

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Attachment downloads (must be before isqm routes to avoid route conflicts)
Route::middleware('auth')->group(function () {
    Route::get('/attachments/{attachment}/download', [IsqmEntryController::class, 'downloadAttachment'])->name('attachments.download');
    Route::delete('/attachments/{attachment}', [IsqmEntryController::class, 'deleteAttachment'])->name('attachments.delete');
});

Route::prefix('isqm')->name('isqm.')->middleware('auth')->group(function () {
    Route::get('/', [IsqmEntryController::class, 'index'])->name('index');
    Route::get('/compliance-now', [IsqmEntryController::class, 'complianceNow'])->name('compliance');
    Route::get('/trashed', [IsqmEntryController::class, 'trashed'])->name('trashed');
    Route::post('/trashed/{id}/restore', [IsqmEntryController::class, 'restore'])->name('restore');
    Route::delete('/trashed/{id}/force', [IsqmEntryController::class, 'forceDelete'])->name('force-delete');
    Route::get('/create', [IsqmEntryController::class, 'create'])->name('create');
    Route::post('/', [IsqmEntryController::class, 'store'])->name('store');
    Route::post('/bulk', [IsqmEntryController::class, 'bulkUpdate'])->name('bulk.update');
    Route::get('/{isqm}', [IsqmEntryController::class, 'show'])->name('show');
    Route::get('/{isqm}/edit', [IsqmEntryController::class, 'edit'])->name('edit');
    Route::put('/{isqm}', [IsqmEntryController::class, 'update'])->name('update');
    Route::delete('/{isqm}', [IsqmEntryController::class, 'destroy'])->name('destroy');
    Route::get('/import/form', [IsqmEntryController::class, 'importForm'])->name('import.form');
    Route::post('/import', [IsqmEntryController::class, 'import'])->name('import');
});

Route::prefix('lists')->name('lists.')->middleware(['auth','role:admin,manager'])->group(function () {
    Route::get('/monitoring', [MonitoringActivityController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/create', [MonitoringActivityController::class, 'create'])->name('monitoring.create');
    Route::post('/monitoring', [MonitoringActivityController::class, 'store'])->name('monitoring.store');
    Route::get('/monitoring/{monitoring}/edit', [MonitoringActivityController::class, 'edit'])->name('monitoring.edit');
    Route::put('/monitoring/{monitoring}', [MonitoringActivityController::class, 'update'])->name('monitoring.update');
    Route::delete('/monitoring/{monitoring}', [MonitoringActivityController::class, 'destroy'])->name('monitoring.destroy');

    Route::get('/deficiency', [DeficiencyTypeController::class, 'index'])->name('deficiency.index');
    Route::get('/deficiency/create', [DeficiencyTypeController::class, 'create'])->name('deficiency.create');
    Route::post('/deficiency', [DeficiencyTypeController::class, 'store'])->name('deficiency.store');
    Route::get('/deficiency/{deficiency}/edit', [DeficiencyTypeController::class, 'edit'])->name('deficiency.edit');
    Route::put('/deficiency/{deficiency}', [DeficiencyTypeController::class, 'update'])->name('deficiency.update');
    Route::delete('/deficiency/{deficiency}', [DeficiencyTypeController::class, 'destroy'])->name('deficiency.destroy');
});

Route::prefix('clients')->name('clients.')->middleware(['auth','role:admin,manager'])->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('index');
    Route::get('/create', [ClientController::class, 'create'])->name('create');
    Route::post('/', [ClientController::class, 'store'])->name('store');
    Route::get('/{client}/edit', [ClientController::class, 'edit'])->name('edit');
    Route::put('/{client}', [ClientController::class, 'update'])->name('update');
    Route::delete('/{client}', [ClientController::class, 'destroy'])->name('destroy');
});

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/notifications/{notification}/read-api', [NotificationController::class, 'markReadApi'])->name('notifications.read-api');
    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit')->middleware('role:admin');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update')->middleware('role:admin');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportsController::class, 'exportCsv'])->name('reports.export');
    Route::get('/reports/export-excel', [ReportsController::class, 'exportExcel'])->name('reports.export.excel');
    Route::get('/reports/compliance-export', [ReportsController::class, 'exportCompliance'])->name('reports.export.compliance');
    Route::get('/risks', [RiskController::class, 'index'])->name('risks.index');
    Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-logs.index')->middleware('role:admin,manager');
    
    // ISQM Area Pages
    Route::get('/governance', [\App\Http\Controllers\AreaController::class, 'governance'])->name('areas.governance');
    Route::get('/ethical', [\App\Http\Controllers\AreaController::class, 'ethical'])->name('areas.ethical');
    Route::get('/acceptance', [\App\Http\Controllers\AreaController::class, 'acceptance'])->name('areas.acceptance');
    Route::get('/engagement', [\App\Http\Controllers\AreaController::class, 'engagement'])->name('areas.engagement');
    Route::get('/resources', [\App\Http\Controllers\AreaController::class, 'resources'])->name('areas.resources');
    Route::get('/information', [\App\Http\Controllers\AreaController::class, 'information'])->name('areas.information');
    
    // Users Management
    Route::prefix('users')->name('users.')->middleware('role:admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
    });
});
