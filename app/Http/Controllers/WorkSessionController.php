<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use App\Models\WorkSession;
use App\Services\WorkSession\StartWorkSessionService;
use App\Services\WorkSession\StopWorkSessionService;
use Illuminate\Http\Request;

class WorkSessionController extends Controller
{
    public function start(
        WorkRequest $workRequest,
        StartWorkSessionService $service
    )
    {

        $service->execute(
            $workRequest,
            auth()->user()
        );

        return back()->with(
            'success',
            'Work Session dimulai.'
        );

    }

    public function stop(
        WorkSession $workSession,
        StopWorkSessionService $service
    )
    {

        $service->execute(
            $workSession
        );

        return back()->with(
            'success',
            'Work Session selesai.'
        );

    }
}
