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
use App\Http\Controllers\WorkSessionController;
use App\Http\Controllers\WorkSessionOutputController;
use App\Models\TelegramUser;
use App\Services\Telegram\CreateWorkRequestFromTelegramService;
use App\Services\Telegram\TelegramRequestParser;
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

    Route::post(
        '/work-request/{workRequest}/start',
        [WorkSessionController::class, 'start']
    )->name('work-session.start');

    Route::patch(
        '/work-session/{workSession}/stop',
        [WorkSessionController::class, 'stop']
    )->name('work-session.stop');

    Route::post(
        '/work-session/{workSession}/outputs',
        [WorkSessionOutputController::class, 'store']
    )->name('work-session-output.store');

    Route::delete(
        '/work-session-output/{workSessionOutput}',
        [WorkSessionOutputController::class, 'destroy']
    )->name('work-session-output.destroy');
});
Route::get('/test-telegram-parser', function (
    TelegramRequestParser $parser
) {

    $message = <<<'TEXT'
/req:ketapang
- dashboard eksekutif | direktur
- form bank darah | laborat
- monitoring kasir | keuangan
TEXT;

    return $parser->parse($message);
});


Route::get('/test-telegram-request', function () {

    $message = <<<'TEXT'
/req:ketapang
- dashboard eksekutif | direktur
- form bank darah | it
- monitoring kasir | keuangan
TEXT;

    $telegramUser = TelegramUser::firstOrFail();

    $parser = app(TelegramRequestParser::class);

    $parsed = $parser->parse($message);

    $service = app(CreateWorkRequestFromTelegramService::class);

    $created = $service->execute(
        $parsed,
        $telegramUser
    );

    dd([
        'parsed' => $parsed,

        'created' => collect($created)->map(
            fn ($workRequest) => [
                'id' => $workRequest->id,
                'kode' => $workRequest->kode,
                'judul' => $workRequest->judul,
                'unit_kerja_id' => $workRequest->unit_kerja_id,
                'requester_unit_id' => $workRequest->requester_unit_id,
                'status_id' => $workRequest->status_id,
                'priority_id' => $workRequest->priority_id,
                'created_by' => $workRequest->created_by,
            ]
        )->values(),
    ]);
});


require __DIR__.'/auth.php';
require __DIR__.'/webhook-tele.php';
