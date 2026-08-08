<?php
use App\Livewire\Dashboard\Workload\Index as WorkloadDashboard;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    
    Route::get(
        '/dashboard/workload',
        WorkloadDashboard::class
    )->name('dashboard.workload');

});