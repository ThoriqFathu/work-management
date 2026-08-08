<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkSessionOutput\StoreWorkSessionOutputRequest;
use App\Models\WorkSession;
use App\Models\WorkSessionOutput;
use App\Services\WorkSessionOutput\DeleteWorkSessionOutputService;
use App\Services\WorkSessionOutput\StoreWorkSessionOutputService;

class WorkSessionOutputController extends Controller
{
    public function store(
        StoreWorkSessionOutputRequest $request,
        WorkSession $workSession,
        StoreWorkSessionOutputService $service
    ) {
        $service->execute(
            $workSession,
            $request->validated()
        );

        return back()->with(
            'success',
            'Output berhasil ditambahkan.'
        );
    }

    public function destroy(
        WorkSessionOutput $workSessionOutput,
        DeleteWorkSessionOutputService $service
    ){

        $service->execute(
            $workSessionOutput
        );

        return back()->with(
            'success',
            'Output berhasil dihapus.'
        );

    }
}