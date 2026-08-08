<?php

namespace App\Livewire\WorkActivities;

use App\Models\RequesterUnit;
use App\Models\UnitKerja;
use App\Models\WorkActivity;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filterTipe = '';

    public string $filterRequester = '';

    public string $filterUnitKerja = '';

    public string $filterPeriode = 'today';

    public function delete(int $id): void
    {
        $activity = WorkActivity::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $activity->delete();

        session()->flash(
            'success',
            'Aktivitas berhasil dihapus.'
        );
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterTipe(): void
    {
        $this->resetPage();
    }

    public function updatedFilterRequester(): void
    {
        $this->resetPage();
    }
    public function updatedFilterUnitKerja(): void
    {
        $this->resetPage();
    }

    public function updatedFilterPeriode(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = WorkActivity::query()
            ->with([
                'user',
                'requesterUnit',
            ])
            ->where('user_id', auth()->id());

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (filled($this->search)) {
            $search = trim($this->search);

            $query->where(function ($query) use ($search) {
                $query
                    ->where('ringkasan', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%")
                    ->orWhere('channel', 'like', "%{$search}%")
                    ->orWhereHas(
                        'requesterUnit',
                        function ($query) use ($search) {
                            $query->where(
                                'nama',
                                'like',
                                "%{$search}%"
                            );
                        }
                    )
                    ->orWhereHas(
                        'unitKerja',
                        function ($query) use ($search) {
                            $query->where(
                                'nama',
                                'like',
                                "%{$search}%"
                            );
                        }
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tipe
        |--------------------------------------------------------------------------
        */

        if (filled($this->filterTipe)) {
            $query->where(
                'tipe',
                $this->filterTipe
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Unit Kerja
        |--------------------------------------------------------------------------
        */

        if (filled($this->filterUnitKerja)) {
            $query->where(
                'unit_kerja_id',
                $this->filterUnitKerja
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Requester
        |--------------------------------------------------------------------------
        */

        if (filled($this->filterRequester)) {
            $query->where(
                'requester_unit_id',
                $this->filterRequester
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Periode
        |--------------------------------------------------------------------------
        */

        $now = now();

        match ($this->filterPeriode) {

            'today' => $query->whereDate(
                'created_at',
                $now->toDateString()
            ),

            'yesterday' => $query->whereDate(
                'created_at',
                $now->copy()
                    ->subDay()
                    ->toDateString()
            ),

            '7days' => $query->where(
                'created_at',
                '>=',
                $now->copy()->subDays(7)
            ),

            'month' => $query
                ->whereYear(
                    'created_at',
                    $now->year
                )
                ->whereMonth(
                    'created_at',
                    $now->month
                ),

            default => null,
        };

        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        $summaryQuery = clone $query;

        $totalAktivitas = $summaryQuery->count();

        $totalDurasi = $summaryQuery
            ->sum('durasi_menit');

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $activities = $query
            ->latest('created_at')
            ->paginate(15);
        

        return view(
            'livewire.work-activities.index',
            [
                'activities' => $activities,
                'requesterUnits' => RequesterUnit::query()
                    ->where('aktif', true)
                    ->orderBy('nama')
                    ->get(),
                'unitKerjas' => UnitKerja::query()
                    ->where('aktif', true)
                    ->orderBy('nama')
                    ->get(),

                'totalAktivitas' => $totalAktivitas,
                'totalDurasi' => $totalDurasi,
            ]
        )->extends('layouts.app')
        ->section('content');;
    }
}