<?php

namespace App\Services;

use App\Models\Priority;
use App\Models\Status;
use App\Models\TaskLog;
use App\Models\WorkRequest;
use App\Services\ActivityLog\ActivityLogService;

class WorkRequestService
{

    public function __construct(
        protected TaskLogService $taskLogService,
        protected ActivityLogService $activityLogService
    ) {
    }
    public function paginate(array $filter = [])
    {
        return WorkRequest::query()
            ->with([
                'unitKerja',
                'requesterUnit',
                'category',
                'priority',
                'status',
            ])
            ->when($filter['search'] ?? null, function ($q, $search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('kode', 'like', "%{$search}%")
                    ->orWhere('judul', 'like', "%{$search}%");
                });
            })
            ->when($filter['unit_kerja_id'] ?? null, function ($q, $id) {
                $q->where('unit_kerja_id', $id);
            })
            ->when($filter['status_id'] ?? null, function ($q, $id) {
                $q->where('status_id', $id);
            })
            ->when($filter['priority_id'] ?? null, function ($q, $id) {
                $q->where('priority_id', $id);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
    }
    // public function create(array $data)
    // {
    //     $lastId = WorkRequest::max('id') + 1;

    //     $data['kode'] = 'WR' . str_pad($lastId, 6, '0', STR_PAD_LEFT);

    //     $data['created_by'] = auth()->id();

    //     $data['request_date'] = now();

    //     $workRequest = WorkRequest::create($data);

    //     $this->taskLogService->add(
    //         $workRequest,
    //         'Membuat Work Request'
    //     );


    //     return $workRequest;
    // }
    public function create(array $data): WorkRequest
    {
        $lastId = WorkRequest::max('id') + 1;

        $data['kode'] = 'WR'.str_pad($lastId, 6, '0', STR_PAD_LEFT);

        $data['created_by'] = auth()->id();

        $data['request_date'] = now();

        $data['status_id'] = Status::where('nama', 'Request')->value('id');

        $data['priority_id'] = Priority::where('nama', 'Medium')->value('id');

        $workRequest = WorkRequest::create($data);

        $this->activityLogService->log(

            subject: $workRequest,

            action: 'created',

            description: 'Membuat Work Request',

        );


        return $workRequest;
    }

    public function update(
        WorkRequest $workRequest,
        array $data
    )
    {
        $old = $workRequest->only([
            'judul',
            'deskripsi',
            'priority_id',
            'status_id',
            'category_id',
            'unit_kerja_id',
        ]);
        $workRequest->update($data);

        $this->activityLogService->log(

            subject: $workRequest,

            action: 'updated',

            description: 'Mengubah Work Request',

            old: $old,

            new: $workRequest->only([
                'judul',
                'deskripsi',
                'priority_id',
                'status_id',
                'category_id',
                'unit_kerja_id',
            ]),

        );

        return $workRequest;
    }

    public function changeStatus(
        WorkRequest $workRequest,
        int $statusId
    ): void {

        $status = Status::findOrFail($statusId);

        $oldStatus = $workRequest->status;

        $workRequest->update([
            'status_id' => $status->id,
        ]);

        $this->activityLogService->log(
            subject: $workRequest,
            action: 'status_changed',
            description: "Status {$oldStatus->nama} → {$status->nama}",
            old: [
                'status_id' => $oldStatus->id,
            ],
            new: [
                'status_id' => $status->id,
            ]
        );

    }
    public function delete(
        WorkRequest $workRequest
    ): void {

        $this->activityLogService->log(

            subject: $workRequest,

            action: 'deleted',

            description: 'Menghapus Work Request',

        );

        $workRequest->delete();
    }

    // public function nextStatuses(
    //     WorkRequest $workRequest
    // )
    // {
    //     return match ($workRequest->status->nama) {

    //         'Request' => Status::where('nama', 'Analisa')->get(),

    //         'Analisa' => Status::where('nama', 'Todo')->get(),

    //         'Todo' => Status::where('nama', 'Progress')->get(),

    //         'Progress' => Status::whereIn(
    //             'nama',
    //             ['Waiting', 'Testing']
    //         )->get(),

    //         'Waiting' => Status::where(
    //             'nama',
    //             'Progress'
    //         )->get(),

    //         'Testing' => Status::where(
    //             'nama',
    //             'Done'
    //         )->get(),

    //         default => collect(),

    //     };
    // }
    public function availableStatuses(WorkRequest $workRequest)
    {
        return Status::query()
            ->whereKeyNot($workRequest->status_id)
            ->orderBy('id')
            ->get();
    }
}