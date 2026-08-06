<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\CategoryController;
use App\Http\Controllers\Master\LabelController;
use App\Http\Controllers\Master\PriorityController;
use App\Http\Controllers\Master\RequesterUnitController;
use App\Http\Controllers\Master\StatusController;
use App\Http\Controllers\Master\UnitKerjaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

    Route::prefix('master')
        ->name('master.')
        ->group(function () {

            Route::resource('unit-kerja', UnitKerjaController::class);

            Route::resource('requester-unit', RequesterUnitController::class);

            Route::resource('category', CategoryController::class);

            Route::resource('priority', PriorityController::class);

            Route::resource('status', StatusController::class);

            Route::resource('label', LabelController::class);

        });

    Route::resource('work-request', WorkRequestController::class);
  
    Route::patch(
        'work-request/{workRequest}/change-status',
        [WorkRequestController::class, 'changeStatus']
    )->name('work-request.change-status');
});

require __DIR__.'/auth.php';
