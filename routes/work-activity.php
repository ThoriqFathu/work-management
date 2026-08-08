<?php
use App\Livewire\WorkActivities\Create;
use Illuminate\Support\Facades\Route;

use App\Livewire\WorkActivities\Index;

Route::middleware('auth')->group(function () {

    Route::get(
        '/work-activities',
        Index::class
    )->name('work-activities.index');

    Route::get(
        '/work-activities/create',
        Create::class
    )->name('work-activities.create');

});