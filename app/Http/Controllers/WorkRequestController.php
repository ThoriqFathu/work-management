<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkRequestRequest;
use App\Http\Requests\UpdateWorkRequestRequest;
use App\Models\Category;
use App\Models\Priority;
use App\Models\RequesterUnit;
use App\Models\Status;
use App\Models\UnitKerja;
use App\Models\WorkRequest;
use App\Models\WorkSession;
use App\Services\ActivityLog\GetActivityTimelineService;
use App\Services\UnitKerjaService;
use App\Services\WorkRequestService;
use App\Services\WorkSession\SessionCalculatorService;
use Illuminate\Http\Request;

class WorkRequestController extends Controller
{
    public function __construct(
        protected WorkRequestService $service
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('work-request.index', [

            'items' => $this->service->paginate(
                $request->only([
                    'search',
                    'unit_kerja_id',
                    'status_id',
                    'priority_id',
                ])
            ),

            'unitKerjas' => UnitKerja::orderBy('nama')->get(),
            'statuses' => Status::get(),
            'priorities' => Priority::orderBy('urutan')->get(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('work-request.create', [

            'unitKerjas' => UnitKerja::orderBy('nama')->get(),

            'requesterUnits' => RequesterUnit::orderBy('nama')->get(),

            'categories' => Category::orderBy('nama')->get(),

            'priorities' => Priority::orderBy('urutan')->get(),

            'statuses' => Status::orderBy('id')->get(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkRequestRequest $request)
    {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('work-request.index')
            ->with('success', 'Work Request berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function show(
        WorkRequest $workRequest, 
        SessionCalculatorService $calculator,
        GetActivityTimelineService $timelineService,    
    )
    {
        // $workRequest->load([
        //     'unitKerja',
        //     'requesterUnit',
        //     'category',
        //     'priority',
        //     'status',
        //     'comments',
        //     'files',
        //     'logs',
        // ]);

        $workRequest->load([

            'unitKerja',
            'requesterUnit',
            'category',
            'priority',
            'status',

            'logs.user',

            'workSessions' => function ($query) {

                $query->latest('started_at')
                    ->with('user');

            },

        ]);

        $totalDuration = $calculator->totalHours($workRequest);

        $activeSession = WorkSession::query()
            ->where('user_id', auth()->id())
            ->whereNull('ended_at')
            ->first();

        $timeline = $timelineService->execute(
            $workRequest
        );

        return view(
            'work-request.show',
            [
                'workRequest' => $workRequest,
                'statuses' => $this->service->availableStatuses($workRequest),
                'workSessions' => function ($query) {

                    $query
                        ->with([
                            'user',
                            'outputs'
                        ])
                        ->latest('started_at');

                },
                'totalDuration' => $totalDuration,
                'activeSession' => $activeSession,
                'timeline'      => $timeline,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateWorkRequestRequest $request,
        WorkRequest $workRequest
    ) {
        $this->service->update(
            $workRequest,
            $request->validated()
        );

        return redirect()
            ->route('work-request.show', $workRequest)
            ->with('success', 'Work Request berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkRequest $workRequest)
    {
        $this->service->delete($workRequest);

        return redirect()
            ->route('work-request.index')
            ->with('success', 'Work Request berhasil dihapus.');
    }

    public function changeStatus(
        Request $request,
        WorkRequest $workRequest
    ) {
        $request->validate([
            'status_id' => ['required', 'exists:statuses,id'],
        ]);

        $this->service->changeStatus(
            $workRequest,
            $request->status_id
        );

        return back()->with(
            'success',
            'Status berhasil diubah.'
        );
    }

    public function edit(WorkRequest $workRequest)
    {
        return view('work-request.edit', [
            'workRequest'    => $workRequest,
            'unitKerjas'     => UnitKerja::orderBy('nama')->get(),
            'requesterUnits' => RequesterUnit::orderBy('nama')->get(),
            'categories'     => Category::orderBy('nama')->get(),
            'priorities'     => Priority::orderBy('urutan')->get(),
            'statuses'       => Status::get(),
        ]);
    }
}
