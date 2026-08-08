<?php

namespace App\Services\Telegram;

use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ResolveUnitKerjaService
{
    public function execute(string $keyword): UnitKerja
    {
        $keyword = trim($keyword);

        $units = UnitKerja::query()
            ->where('aktif', true)
            ->where('nama', 'like', "%{$keyword}%")
            ->get();

        if ($units->isEmpty()) {
            throw ValidationException::withMessages([
                'unit_kerja' => "Unit kerja '{$keyword}' tidak ditemukan.",
            ]);
        }

        if ($units->count() > 1) {
            $list = $units
                ->map(fn ($unit) => "- {$unit->nama}")
                ->implode("\n");

            throw ValidationException::withMessages([
                'unit_kerja' =>
                    "Unit kerja '{$keyword}' ambigu. Ditemukan:\n{$list}\n\n"
                    . "Gunakan nama yang lebih spesifik.",
            ]);
        }

        return $units->first();
    }
}