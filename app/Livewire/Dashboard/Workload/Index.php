<?php

namespace App\Livewire\Dashboard\Workload;

use App\Analytics\Features\Workload\DTO\WorkloadFilter;
use App\Analytics\Features\Workload\Managers\WorkloadManager;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    public string $periode = 'bulan_ini';

    public string $startDate;

    public string $endDate;

    public ?int $unitKerjaId = null;

    public ?int $userId = null;

    public ?int $requesterUnitId = null;


    public function mount(): void
    {

        $this->setPeriodeTanggal();
    }


    public function updatedPeriode(): void
    {
        if ($this->periode !== 'custom') {
            $this->setPeriodeTanggal();
        }
    }


    protected function setPeriodeTanggal(): void
    {
        $today = now();

        switch ($this->periode) {

            case 'bulan_ini':
                $this->startDate = $today
                    ->copy()
                    ->startOfMonth()
                    ->toDateString();

                $this->endDate = $today
                    ->copy()
                    ->endOfMonth()
                    ->toDateString();
                break;

            case 'bulan_lalu':
                $this->startDate = $today
                    ->copy()
                    ->subMonth()
                    ->startOfMonth()
                    ->toDateString();

                $this->endDate = $today
                    ->copy()
                    ->subMonth()
                    ->endOfMonth()
                    ->toDateString();
                break;

            case '7_hari':
                $this->startDate = $today
                    ->copy()
                    ->subDays(6)
                    ->toDateString();

                $this->endDate = $today
                    ->copy()
                    ->toDateString();
                break;
        }
    }


    public function render(
        WorkloadManager $manager
    ) {
        $filter = new WorkloadFilter(
            startDate: Carbon::parse(
                $this->startDate
            )->startOfDay(),

            endDate: Carbon::parse(
                $this->endDate
            )->endOfDay(),

            unitKerjaId: $this->unitKerjaId,

            userId: $this->userId,

            requesterUnitId: $this->requesterUnitId,
        );


        $result = $manager->calculate($filter);

        $users = User::query()
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);


        return view(
            'livewire.dashboard.workload.index',
            [
                'result' => $result,
                'users' => $users,
            ]
        )->extends('layouts.app')->section('content');;
    }


    public function formatDuration(int $minutes): string
    {
        $hours = intdiv($minutes, 60);

        $remainingMinutes = $minutes % 60;

        if ($hours === 0) {
            return "{$remainingMinutes}m";
        }

        if ($remainingMinutes === 0) {
            return "{$hours}j";
        }

        return "{$hours}j {$remainingMinutes}m";
    }
}