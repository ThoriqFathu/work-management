<?php

namespace App\Livewire\WorkActivities;

use App\Models\RequesterUnit;
use App\Services\WorkActivity\CreateWorkActivityService;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    public string $tipe = '';

    public ?int $requesterUnitId = null;

    public string $channel = '';

    public ?int $durasiMenit = null;

    public string $ringkasan = '';

    public function save(
        CreateWorkActivityService $service
    ): void {
        $validated = $this->validate([
            'tipe' => [
                'required',
                'string',
                'max:50',
            ],

            'requesterUnitId' => [
                'nullable',
                'integer',
                'exists:requester_units,id',
            ],

            'channel' => [
                'nullable',
                'string',
                'max:50',
            ],

            'durasiMenit' => [
                'required',
                'integer',
                'min:1',
            ],

            'ringkasan' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        $service->execute(
            user: auth()->user(),
            tipe: $validated['tipe'],
            durasiMenit: $validated['durasiMenit'],
            ringkasan: $validated['ringkasan'],
            requesterUnitId: $validated['requesterUnitId'],
            channel: $validated['channel'] ?: null,
        );

        $this->reset([
            'tipe',
            'requesterUnitId',
            'channel',
            'durasiMenit',
            'ringkasan',
        ]);

        session()->flash(
            'success',
            'Aktivitas berhasil dicatat.'
        );
    }

    public function render()
    {
        return view(
            'livewire.work-activities.create',
            [
                'requesterUnits' => RequesterUnit::query()
                    ->where('aktif', true)
                    ->orderBy('nama')
                    ->get(),
            ]
        )->extends('layouts.app')
        ->section('content');
    }
}