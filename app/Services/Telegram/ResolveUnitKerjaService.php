<?php

namespace App\Services\Telegram;

use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResolveUnitKerjaService
{
    public function execute(string $name): UnitKerja
    {
        $name = trim($name);

        $unitKerja = UnitKerja::query()
            ->whereRaw(
                'LOWER(nama) LIKE ?',
                ['%' . mb_strtolower($name) . '%']
            )
            ->first();

        if (! $unitKerja) {
            throw new ModelNotFoundException(
                "Unit kerja '{$name}' tidak ditemukan."
            );
        }

        return $unitKerja;
    }
}