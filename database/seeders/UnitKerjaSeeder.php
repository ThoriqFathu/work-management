<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            'RSUD Ketapang',
            'RSIA HS',
            'PT Digital Star Code',
        ];

        foreach ($items as $item) {
            UnitKerja::updateOrCreate(
                ['nama' => $item],
                ['aktif' => true]
            );
        }
    }
}